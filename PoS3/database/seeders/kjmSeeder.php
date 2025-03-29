<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class kjmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id_kjm' => 'M-001', 'nama' => 'Ahmad', 'email' => 'ahhmad@gmail.com'],
        ];
        DB::table('kjm')->insert($data);
    }
}
