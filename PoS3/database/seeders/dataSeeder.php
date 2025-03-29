<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class dataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id_data' => 'D-01', 'nama_data' => 'Kriteria1'],
            ['id_data' => 'D-02', 'nama_data' => 'Kriteria2'],
            ['id_data' => 'D-03', 'nama_data' => 'Kriteria3'],
        ];
        DB::table('data')->insert($data);
    }
}