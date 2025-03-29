<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class koordinatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id_koor' => 'K-001', 'nama' => 'Devita Sari', 'email' => 'devita17@gmail.com'],
        ];
        DB::table('koordinator')->insert($data);
    }
}