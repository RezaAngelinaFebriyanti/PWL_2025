<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class anggotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id_anggota' => 'G-001', 'nama' => 'Viorenza', 'id_jurusan' => 'J-01', 'email' => 'viorenza@gmail.com'],
        ];
        DB::table('anggota')->insert($data);
    }
}