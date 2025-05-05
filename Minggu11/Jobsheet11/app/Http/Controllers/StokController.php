<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\BarangModel;
use App\Models\UserModel;
use App\Models\StokModel;

class StokController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Data Stok Barang',
            'list'  => ['Home', 'Stok']
        ];

        $page = (object) [
            'title' => 'Daftar stok barang yang tercatat'
        ];

        $activeMenu = 'stok'; // set menu aktif ke stok

        $stok = StokModel::with(['barang', 'user'])->get(); // ambil data stok dengan relasi barang & user
        $barang = BarangModel::all();
        $user = UserModel::all();

        return view('stok.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'stok' => $stok,
            'barang' => $barang,
            'user' => $user,
            'activeMenu' => $activeMenu
        ]);
    }

    public function list(Request $request)
    {
        $stok = StokModel::with(['barang', 'user']);

        // Filter jika ada barang_id dari request
        if ($request->barang_id) {
            $stok->where('barang_id', $request->barang_id);
        }

        return DataTables::of($stok)
            ->addIndexColumn()
            ->addColumn('barang_kode', function ($s) {
                return $s->barang->barang_kode ?? '-';
            })
            ->addColumn('barang_nama', function ($s) {
                return $s->barang->barang_nama ?? '-';
            })
            ->addColumn('user_nama', function ($s) {
                return $s->user->nama ?? '-';
            })
            ->addColumn('aksi', function ($s) {
                $btn = '<button onclick="modalAction(\'' . url('/stok/' . $s->stok_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $s->stok_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $s->stok_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
    
    public function create_ajax()
    {
            $barang = BarangModel::select('barang_id', 'barang_nama')->get();
            $user = UserModel::select('user_id', 'nama')->get();

            return view('stok.create_ajax', [
                'barang' => $barang,
                'user' => $user
            ]);
        }

    public function store_ajax(Request $request){
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'barang_id' => 'required|integer|exists:m_barang,barang_id',
                'user_id' => 'required|integer|exists:m_user,user_id',
                'jumlah' => 'required|integer|min:1'
            ];
    
        $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }
    
        $existingStok = StokModel::where('barang_id', $request->barang_id)->first();
            if ($existingStok) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data stok untuk barang ini sudah ada. Silakan edit data yang tersedia.',
                ]);
            }
    
            StokModel::create($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data stok berhasil disimpan',
                ]);
            }
            return redirect('/');
    }

    public function import(){
        return view('stok.import');
    }
    
    public function import_ajax(Request $request) {
        if($request->ajax() || $request->wantsJson()){
            $rules = [
                // validasi file harus xls atau xlsx, max 1MB
                'file_stok' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                    ]);
            }

            $file = $request->file('file_stok'); // ambil file dari request

            $reader = IOFactory::createReader('Xlsx'); // load reader file excel
            $reader->setReadDataOnly(true); // hanya membaca data
            $spreadsheet = $reader->load($file->getRealPath()); // load file excel
            $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif

            $data = $sheet->toArray(null, false, true, true); // ambil data excel

            $insert = [];
            if(count($data) > 1){ // jika data lebih dari 1 baris
                foreach ($data as $baris => $value){
                    if($baris > 1){ // baris ke 1 adalah header, maka lewati
                        $insert[] = [
                            'barang_id' => $value['A'],
                            'user_id' => $value['B'],
                            'jumlah' => $value['C'],
                            'created_at' => now(),
                        ];
                    }
                }

                if(count($insert) > 0){
                    // insert data ke database, jika data sudah ada, maka diabaikan
                    StokModel::insertOrIgnore($insert);
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diimport'
                ]);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang diimport'
                ]);
            }
        }
        return redirect('/');
    }

    public function export_excel()
    {
        // Ambil data stok lengkap dengan relasi barang dan user
        $stok = StokModel::with(['barang', 'user'])->orderBy('stok_id')->get();

        // Buat spreadsheet baru
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();

        // Set judul kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Barang');
        $sheet->setCellValue('C1', 'Nama Barang');
        $sheet->setCellValue('D1', 'Jumlah');
        $sheet->setCellValue('E1', 'Nama User');
        $sheet->setCellValue('F1', 'Tanggal Input');

        $sheet->getStyle('A1:F1')->getFont()->setBold(true);

        // Isi data
        $no = 1;
        $baris = 2;
        foreach ($stok as $s) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $s->barang->barang_kode ?? '-');
            $sheet->setCellValue('C' . $baris, $s->barang->barang_nama ?? '-');
            $sheet->setCellValue('D' . $baris, $s->jumlah);
            $sheet->setCellValue('E' . $baris, $s->user->nama ?? '-');
            $sheet->setCellValue('F' . $baris, $s->created_at ? $s->created_at->format('Y-m-d H:i:s') : '-');

            $baris++;
            $no++;
        }

        // Set kolom agar auto resize
        foreach (range('A', 'F') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Data Stok');

        // Generate dan download file
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data_Stok_' . date('Y-m-d_H-i-s') . '.xlsx';

        // Set header untuk download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }

    public function export_pdf()
    {
        $stok = StokModel::with(['barang', 'user'])->orderBy('stok_id')->get();

        // Gunakan view khusus stok (stok/export_pdf.blade.php)
        $pdf = Pdf::loadView('stok.export_pdf', ['stok' => $stok]);
        $pdf->setPaper('a4', 'landscape'); // karena tabel lebih lebar
        $pdf->setOption("isRemoteEnabled", true);
        $pdf->render();

        return $pdf->stream('Data Stok ' . date('Y-m-d H:i:s') . '.pdf');
    }

    public function show($id)
    {
        $stok = StokModel::with(['barang', 'user'])->findOrFail($id);

        return view('stok.show', [
            'page' => [
                'title' => 'Detail Stok Barang',
                'breadcrumbs' => [
                    ['label' => 'Stok', 'url' => route('stok.index')],
                    ['label' => 'Detail', 'active' => true],
                ],
            ],
            'stok' => $stok,
            'activeMenu' => 'stok',
        ]);
    }

    public function show_ajax(string $id)
    {
        $stok = StokModel::with(['barang', 'user'])->find($id);
        return view('stok.show_ajax', ['stok' => $stok]);
    }

    public function edit_ajax(string $id)
    {
        $stok = StokModel::find($id);
        $barang = BarangModel::all();
        $user = UserModel::all();

        return view('stok.edit_ajax', [
            'stok' => $stok,
            'barang' => $barang,
            'user' => $user
        ]);
    }

    public function update_ajax(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'barang_id' => 'required|integer|exists:m_barang,barang_id',
                'user_id' => 'required|integer|exists:m_user,user_id',
                'jumlah' => 'required|integer|min:1',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            $existingStok = StokModel::where('barang_id', $request->barang_id)
                ->where('stok_id', '!=', $id)
                ->first();

            if ($existingStok) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data stok untuk barang ini sudah ada. Silakan edit data yang sudah ada.',
                ]);
            }

            $stok = StokModel::find($id);
            if ($stok) {
                $stok->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data stok berhasil diubah',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data stok tidak ditemukan',
                ]);
            }
        }
        return redirect('/');
    }

    public function delete_ajax(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $stok = StokModel::find($id);
            if ($stok) {
                $stok->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data stok berhasil dihapus',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data stok tidak ditemukan',
                ]);
            }
        }
        return redirect('/');
    }

    public function confirm_ajax(string $id)
    {
        $stok = StokModel::with(['barang', 'user'])->find($id);
        return view('stok.confirm_ajax', ['stok' => $stok]);
    }
}