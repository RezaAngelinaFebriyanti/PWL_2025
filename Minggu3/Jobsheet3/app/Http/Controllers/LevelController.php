<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LevelController extends Controller
{
    public function index() {
        //DB Facade
        DB::insert('insert into m_level(level_kode, level_name, created_at) values(?,?,?)', ['CUS', 'Pelanggan', now()]); //menginputkan
        return 'Insert data baru berhasil';

        $row = DB::update('update m_level set level_nama = ? where level_kode = ?', ['Customer', 'CUS']);
        return 'Update data berhasil. Jumlah data yang diupdate: ' . $row.' baris'; //update

        $row = DB::delete('delete from m_level where level_kode = ?', ['CUS']); //delete
        return 'Delete data berhasil. Jumlah data yang dihapus: '.$row.' baris';

        $data = DB::select('select * from m_level'); //menampilkan isi tabel
        return view('level', ['data' => $data]);
    }    
}