<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['kategori_kode' => 'K001', 'kategori_nama' => 'Make Up'],
            ['kategori_kode' => 'K002', 'kategori_nama' => 'Body Spa'],
            ['kategori_kode' => 'K003', 'kategori_nama' => 'Hair Care'],
            ['kategori_kode' => 'K004', 'kategori_nama' => 'Skincare'],
            ['kategori_kode' => 'K005', 'kategori_nama' => 'Nail Care'],
        ];
        DB::table('m_kategori')->insert($data);
    }
}
