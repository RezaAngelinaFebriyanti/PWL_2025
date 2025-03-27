<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PenjualanDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['penjualan_id' => 1, 'barang_id' => 1, 'jumlah' => 2, 'harga' => 200000],
            ['penjualan_id' => 1, 'barang_id' => 2, 'jumlah' => 3, 'harga' => 150000],
            ['penjualan_id' => 1, 'barang_id' => 3, 'jumlah' => 1, 'harga' => 50000],
            
            ['penjualan_id' => 2, 'barang_id' => 4, 'jumlah' => 5, 'harga' => 250000],
            ['penjualan_id' => 2, 'barang_id' => 5, 'jumlah' => 2, 'harga' => 120000],
            ['penjualan_id' => 2, 'barang_id' => 6, 'jumlah' => 4, 'harga' => 180000],
            
            ['penjualan_id' => 3, 'barang_id' => 7, 'jumlah' => 3, 'harga' => 90000],
            ['penjualan_id' => 3, 'barang_id' => 8, 'jumlah' => 6, 'harga' => 240000],
            ['penjualan_id' => 3, 'barang_id' => 9, 'jumlah' => 2, 'harga' => 100000],
            
            ['penjualan_id' => 4, 'barang_id' => 10, 'jumlah' => 1, 'harga' => 45000],
            ['penjualan_id' => 4, 'barang_id' => 1, 'jumlah' => 7, 'harga' => 350000],
            ['penjualan_id' => 4, 'barang_id' => 2, 'jumlah' => 3, 'harga' => 135000],
        
            ['penjualan_id' => 5, 'barang_id' => 3, 'jumlah' => 4, 'harga' => 160000],
            ['penjualan_id' => 5, 'barang_id' => 4, 'jumlah' => 2, 'harga' => 110000],
            ['penjualan_id' => 5, 'barang_id' => 5, 'jumlah' => 5, 'harga' => 275000],
        
            ['penjualan_id' => 6, 'barang_id' => 6, 'jumlah' => 3, 'harga' => 120000],
            ['penjualan_id' => 6, 'barang_id' => 7, 'jumlah' => 2, 'harga' => 80000],
            ['penjualan_id' => 6, 'barang_id' => 8, 'jumlah' => 6, 'harga' => 270000],
        
            ['penjualan_id' => 7, 'barang_id' => 9, 'jumlah' => 2, 'harga' => 90000],
            ['penjualan_id' => 7, 'barang_id' => 10, 'jumlah' => 1, 'harga' => 40000],
            ['penjualan_id' => 7, 'barang_id' => 1, 'jumlah' => 4, 'harga' => 180000],
        
            ['penjualan_id' => 8, 'barang_id' => 2, 'jumlah' => 3, 'harga' => 120000],
            ['penjualan_id' => 8, 'barang_id' => 3, 'jumlah' => 5, 'harga' => 250000],
            ['penjualan_id' => 8, 'barang_id' => 4, 'jumlah' => 2, 'harga' => 130000],
        
            ['penjualan_id' => 9, 'barang_id' => 5, 'jumlah' => 4, 'harga' => 180000],
            ['penjualan_id' => 9, 'barang_id' => 6, 'jumlah' => 3, 'harga' => 150000],
            ['penjualan_id' => 9, 'barang_id' => 7, 'jumlah' => 1, 'harga' => 50000],
        
            ['penjualan_id' => 10, 'barang_id' => 8, 'jumlah' => 2, 'harga' => 110000],
            ['penjualan_id' => 10, 'barang_id' => 9, 'jumlah' => 3, 'harga' => 135000],
            ['penjualan_id' => 10, 'barang_id' => 10, 'jumlah' => 5, 'harga' => 250000],
        ];
        DB::table('t_penjualan_detail')->insert($data);
    }
}