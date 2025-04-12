<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['barang_id' => 1, 'user_id' => 1, 'jumlah' => 50],
            ['barang_id' => 2, 'user_id' => 2, 'jumlah' => 30],
            ['barang_id' => 3, 'user_id' => 3, 'jumlah' => 40],
            ['barang_id' => 4, 'user_id' => 1, 'jumlah' => 60],
            ['barang_id' => 5, 'user_id' => 2, 'jumlah' => 25],
            ['barang_id' => 6, 'user_id' => 3, 'jumlah' => 35],
            ['barang_id' => 7, 'user_id' => 1, 'jumlah' => 45],
            ['barang_id' => 8, 'user_id' => 2, 'jumlah' => 20],
            ['barang_id' => 9, 'user_id' => 3, 'jumlah' => 55],
            ['barang_id' => 10, 'user_id' => 1, 'jumlah' => 30],
        ];
        DB::table('t_stok')->insert($data);        
    }
}
