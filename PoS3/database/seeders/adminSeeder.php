<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class adminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id_admin' => 'A-001', 'nama' => 'Geisha', 'email' => 'geishaa@gmail.com'],
        ];
        DB::table('admin')->insert($data);
    }
}
