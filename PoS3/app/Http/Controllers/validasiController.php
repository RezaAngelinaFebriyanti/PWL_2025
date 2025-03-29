<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class validasiController extends Controller
{
    //query builder
    public function insert() {
        $data = [
            'id_validasi' => 'V-001',
            'id_koor' => 'K-001',
            'id_dokumen' => 'DOC-001',
            'status' => 'Disetujui'
        ];
        DB::table('validasi')->insert($data);
        return 'Insert data baru berhasil';
    } 
}