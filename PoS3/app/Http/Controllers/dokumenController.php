<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\dokumenModel;

class dokumenController extends Controller
{
    //DB FACADES
    public function insert() {
        DB::insert('insert into dokumen(id_dokumen, id_data, id_tahap, nama_dokumen, isi) values(?, ?, ?, ?, ?)', ['DOC-001', 'D-01', 'T-01', 'Statuta Polinema', 'lorem ipsum']);
        DB::insert('insert into dokumen(id_dokumen, id_data, id_tahap, nama_dokumen, isi) values(?, ?, ?, ?, ?)', ['DOC-002', 'D-02', 'T-02', 'SK FGD', 'lorem ipsum']);

        return 'Insert data baru berhasil';
    }

    //Eloquant
    public function view() {
        $dokumen = dokumenModel::all();
        return view('dokumen', ['dokumen' => $dokumen]);
    }
}