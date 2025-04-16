<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use App\Models\PenjualanModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\DetailPenjualanModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\BarangModel;
use App\Models\StokModel;

class PenjualanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Penjualan',
            'list' => ['Home', 'Penjualan'],
        ];

        $page = (object) [
            'title' => 'Daftar penjualan',
        ];

        $activeMenu = 'penjualan';

        $user = UserModel::all();

        return view('penjualan.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'user' => $user,
        ]);
    }

    // Ambil data penjualan dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $penjualans = PenjualanModel::with('user', 'details')
            ->select('penjualan_id', 'user_id', 'pembeli', 'penjualan_kode', 'penjualan_tanggal');

        if ($request->user_id) {
            $penjualans->where('user_id', $request->user_id);
        }

        return DataTables::of($penjualans)
            ->addIndexColumn()
            ->addColumn('username', function ($penjualan) {
                return $penjualan->user->nama ?? 'N/A';
            })
            ->addColumn('total', function ($penjualan) {
                return 'Rp ' . number_format($penjualan->total, 0, ',', '.');
            })
            ->addColumn('aksi', function ($penjualan) {
                $btn = '<button onclick="modalAction(\'' . url('/penjualan/' . $penjualan->penjualan_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/penjualan/' . $penjualan->penjualan_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/penjualan/' . $penjualan->penjualan_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function import()
    {
        return view('penjualan.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_penjualan' => ['required', 'mimes:xlsx', 'max:1024'],
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            try {
                $file = $request->file('file_penjualan');
                $reader = IOFactory::createReader('Xlsx');
                $reader->setReadDataOnly(true);
                $spreadsheet = $reader->load($file->getRealPath());
                $sheet = $spreadsheet->getActiveSheet();
                $data = $sheet->toArray(null, false, true, true);

                $penjualans = [];
                $details = [];
                $currentPenjualanKode = null;

                if (count($data) > 1) {
                    foreach ($data as $baris => $value) {
                        if ($baris <= 1) {
                            continue; // Lewati header
                        }

                        if (empty($value['B']) && empty($value['E']) && empty($value['F'])) {
                            continue; // Lewati baris kosong
                        }

                        if (!empty($value['B'])) {
                            if (empty($value['A']) || !UserModel::find($value['A'])) {
                                continue;
                            }

                            if (PenjualanModel::where('penjualan_kode', $value['B'])->exists()) {
                                continue;
                            }

                            $tanggal = null;
                            if (is_numeric($value['D'])) {
                                $tanggal = Date::excelToDateTimeObject($value['D'])->format('Y-m-d');
                            } else {
                                try {
                                    $tanggal = Carbon::createFromFormat('d/m/Y', $value['D'])->format('Y-m-d');
                                } catch (\Exception $e) {
                                    continue;
                                }
                            }

                            if (empty($value['C'])) {
                                continue;
                            }

                            $penjualan = [
                                'user_id'           => $value['A'],
                                'penjualan_kode'    => $value['B'],
                                'pembeli'           => $value['C'],
                                'penjualan_tanggal' => $tanggal,
                                'created_at'        => now(),
                                'updated_at'        => now(),
                            ];

                            $currentPenjualanKode = $value['B'];
                            $penjualans[] = $penjualan;
                        }

                        if (!empty($value['E']) && !empty($value['F'])) {
                            $barang = BarangModel::find($value['E']);
                            if (!$barang) {
                                continue;
                            }

                            if (!is_numeric($value['F']) || $value['F'] <= 0) {
                                continue;
                            }

                            if (!$currentPenjualanKode) {
                                continue;
                            }

                            $details[] = [
                                'penjualan_kode' => $currentPenjualanKode, // Digunakan sementara untuk mencocokkan penjualan_id
                                'barang_id'      => $value['E'],
                                'harga'          => $barang->harga_jual,
                                'jumlah'         => (int) $value['F'],
                                'created_at'     => now(),
                                'updated_at'     => now(),
                            ];
                        }
                    }

                    if (count($penjualans) > 0 || count($details) > 0) {
                        DB::beginTransaction();
                        try {
                            if (count($penjualans) > 0) {
                                PenjualanModel::insertOrIgnore($penjualans);
                            }

                            if (count($details) > 0) {
                                $penjualanIds = PenjualanModel::whereIn('penjualan_kode', array_column($details, 'penjualan_kode'))
                                    ->pluck('penjualan_id', 'penjualan_kode');

                                $detailsToInsert = [];
                                foreach ($details as $detail) {
                                    if (isset($penjualanIds[$detail['penjualan_kode']])) {
                                        $detailsToInsert[] = [
                                            'penjualan_id' => $penjualanIds[$detail['penjualan_kode']],
                                            'barang_id'    => $detail['barang_id'],
                                            'harga'        => $detail['harga'],
                                            'jumlah'       => $detail['jumlah'],
                                            'created_at'   => $detail['created_at'],
                                            'updated_at'   => $detail['updated_at'],
                                        ];
                                    }
                                }

                                if (count($detailsToInsert) > 0) {
                                    DetailPenjualanModel::insertOrIgnore($detailsToInsert);
                                }
                            }

                            DB::commit();
                            return response()->json([
                                'status' => true,
                                'message' => 'Data berhasil diimport',
                            ]);
                        } catch (\Exception $e) {
                            DB::rollBack();
                            Log::error('Impor gagal: ' . $e->getMessage());
                            return response()->json([
                                'status' => false,
                                'message' => 'Terjadi kesalahan saat mengimpor: ' . $e->getMessage(),
                            ]);
                        }
                    }

                    return response()->json([
                        'status' => false,
                        'message' => 'Tidak ada data yang valid untuk diimport',
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Impor gagal: ' . $e->getMessage());
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan saat mengimpor: ' . $e->getMessage(),
                ]);
            }
        }
        return redirect('/');
    }

    public function show_ajax(string $id)
    {
        $penjualan = PenjualanModel::with('user', 'details.barang')->find($id);
        if (!$penjualan) {
            return response()->json([
                'status' => false,
                'message' => 'Data penjualan tidak ditemukan',
            ]);
        }
        return view('penjualan.show_ajax', ['penjualan' => $penjualan]);
    }

    public function create_ajax()
    {
        $user = UserModel::all();
        $barangs = BarangModel::all(); // Ambil data barang untuk form
        return view('penjualan.create_ajax', compact('user', 'barangs'));
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'penjualan_kode'    => 'required|string|min:3|unique:t_penjualan,penjualan_kode',
                'pembeli'           => 'required|string|min:3',
                'penjualan_tanggal' => 'required|date',
                'user_id'           => 'required|integer|exists:m_user,user_id',
                'barang_id'         => 'required|array',
                'barang_id.*'       => 'required|integer|exists:m_barang,barang_id',
                'jumlah'            => 'required|array',
                'jumlah.*'          => 'required|integer|min:1',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            try {
                // Gunakan transaksi database untuk memastikan konsistensi
                return DB::transaction(function () use ($request) {
                    // Simpan header transaksi
                    $penjualan = new PenjualanModel();
                    $penjualan->penjualan_kode = $request->penjualan_kode;
                    $penjualan->pembeli = $request->pembeli;
                    $penjualan->penjualan_tanggal = $request->penjualan_tanggal;
                    $penjualan->user_id = $request->user_id;
                    $penjualan->save();

                    // Simpan detail transaksi dan validasi stok
                    foreach ($request->barang_id as $index => $barang_id) {
                        $barang = BarangModel::find($barang_id);
                        $stok = StokModel::where('barang_id', $barang_id)->first();

                        // Validasi stok
                        if (!$stok || $stok->jumlah < $request->jumlah[$index]) {
                            throw new \Exception("Stok barang {$barang->barang_nama} tidak cukup!");
                        }

                        // Simpan detail
                        $detail = new DetailPenjualanModel();
                        $detail->penjualan_id = $penjualan->penjualan_id;
                        $detail->barang_id = $barang_id;
                        $detail->harga = $barang->harga_jual;
                        $detail->jumlah = $request->jumlah[$index];
                        $detail->save();

                        // Kurangi stok
                        $stok->jumlah -= $request->jumlah[$index];
                        $stok->save();
                    }

                    return response()->json([
                        'status' => true,
                        'message' => 'Data penjualan berhasil disimpan',
                    ]);
                });
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal menyimpan data: ' . $e->getMessage(),
                ]);
            }
        }
        return redirect('/');
    }

    public function edit_ajax(string $id)
    {
        $penjualan = PenjualanModel::with('details')->find($id);
        $user = UserModel::select('user_id', 'nama')->get();
        $barangs = BarangModel::all();

        if (!$penjualan) {
            return response()->json([
                'status' => false,
                'message' => 'Data penjualan tidak ditemukan',
            ]);
        }

        return view('penjualan.edit_ajax', ['penjualan' => $penjualan, 'user' => $user, 'barangs' => $barangs]);
    }

    public function update_ajax(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'penjualan_kode'    => 'required|string|min:3|unique:t_penjualan,penjualan_kode,' . $id . ',penjualan_id',
                'user_id'           => 'required|integer|exists:m_user,user_id',
                'pembeli'           => 'required|string|min:3',
                'penjualan_tanggal' => 'required|date',
                'barang_id'         => 'required|array',
                'barang_id.*'       => 'required|integer|exists:m_barang,barang_id',
                'jumlah'            => 'required|array',
                'jumlah.*'          => 'required|integer|min:1',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            try {
                return DB::transaction(function () use ($request, $id) {
                    $penjualan = PenjualanModel::find($id);
                    if (!$penjualan) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Data penjualan tidak ditemukan',
                        ]);
                    }

                    // Kembalikan stok sebelumnya
                    $oldDetails = DetailPenjualanModel::where('penjualan_id', $id)->get();
                    foreach ($oldDetails as $detail) {
                        $stok = StokModel::where('barang_id', $detail->barang_id)->first();
                        if ($stok) {
                            $stok->jumlah += $detail->jumlah;
                            $stok->save();
                        }
                    }

                    // Hapus detail lama
                    DetailPenjualanModel::where('penjualan_id', $id)->delete();

                    // Update header
                    $penjualan->update($request->all());

                    // Simpan detail baru dan validasi stok
                    foreach ($request->barang_id as $index => $barang_id) {
                        $barang = BarangModel::find($barang_id);
                        $stok = StokModel::where('barang_id', $barang_id)->first();

                        if (!$stok || $stok->jumlah < $request->jumlah[$index]) {
                            throw new \Exception("Stok barang {$barang->barang_nama} tidak cukup!");
                        }

                        $detail = new DetailPenjualanModel();
                        $detail->penjualan_id = $penjualan->penjualan_id;
                        $detail->barang_id = $barang_id;
                        $detail->harga = $barang->harga_jual;
                        $detail->jumlah = $request->jumlah[$index];
                        $detail->save();

                        $stok->jumlah -= $request->jumlah[$index];
                        $stok->save();
                    }

                    return response()->json([
                        'status' => true,
                        'message' => 'Data penjualan berhasil diubah',
                    ]);
                });
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal mengubah data: ' . $e->getMessage(),
                ]);
            }
        }
        return redirect('/');
    }
}