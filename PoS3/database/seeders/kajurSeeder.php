<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class kajurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id_kajur' => 'R-001', 'nama' => 'Reza', 'id_jurusan' => 'J-01', 'email' => 'rzangef@gmail.com'],
        ];
        DB::table('kajur')->insert($data);
    }
}