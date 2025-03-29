<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class jurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id_jurusan' => 'J-01', 'nama_jurusan' => 'Administrasi Niaga'],
            ['id_jurusan' => 'J-02', 'nama_jurusan' => 'Teknik Kimia'],
            ['id_jurusan' => 'J-03', 'nama_jurusan' => 'Akutansi'],
            ['id_jurusan' => 'J-04', 'nama_jurusan' => 'Teknik Elektro'],
            ['id_jurusan' => 'J-05', 'nama_jurusan' => 'Teknologi Informasi'],
            ['id_jurusan' => 'J-06', 'nama_jurusan' => 'Teknik Sipil'],
            ['id_jurusan' => 'J-07', 'nama_jurusan' => 'Teknik Mesin'],
        ];
        DB::table('jurusan')->insert($data);
    }
}