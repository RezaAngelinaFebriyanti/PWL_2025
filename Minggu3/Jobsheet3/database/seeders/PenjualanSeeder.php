<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['user_id' => 1, 'barang_id' => 1, 'penjualan_kode' => 'TRX001', 'penjualan_tanggal' => '2024-03-01', 'pembeli' => 'Administrator'],
            ['user_id' => 2, 'barang_id' => 2, 'penjualan_kode' => 'TRX002', 'penjualan_tanggal' => '2024-03-02', 'pembeli' => 'Manager'],
            ['user_id' => 3, 'barang_id' => 3, 'penjualan_kode' => 'TRX003', 'penjualan_tanggal' => '2024-03-03', 'pembeli' => 'Staf/Kasir'],
            ['user_id' => 1, 'barang_id' => 4, 'penjualan_kode' => 'TRX004', 'penjualan_tanggal' => '2024-03-04', 'pembeli' => 'Administrator'],
            ['user_id' => 2, 'barang_id' => 5, 'penjualan_kode' => 'TRX005', 'penjualan_tanggal' => '2024-03-05', 'pembeli' => 'Manager'],
            ['user_id' => 3, 'barang_id' => 6, 'penjualan_kode' => 'TRX006', 'penjualan_tanggal' => '2024-03-06', 'pembeli' => 'Staf/Kasir'],
            ['user_id' => 1, 'barang_id' => 7, 'penjualan_kode' => 'TRX007', 'penjualan_tanggal' => '2024-03-07', 'pembeli' => 'Administrator'],
            ['user_id' => 2, 'barang_id' => 8, 'penjualan_kode' => 'TRX008', 'penjualan_tanggal' => '2024-03-08', 'pembeli' => 'Manager'],
            ['user_id' => 3, 'barang_id' => 9, 'penjualan_kode' => 'TRX009', 'penjualan_tanggal' => '2024-03-09', 'pembeli' => 'Staf/Kasir'],
            ['user_id' => 1, 'barang_id' => 10, 'penjualan_kode' => 'TRX010', 'penjualan_tanggal' => '2024-03-10', 'pembeli' => 'Administrator'],
        ];
        DB::table('t_penjualan')->insert($data);        
    }
}