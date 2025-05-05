<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['kategori_id' => 1, 'barang_kode' => 'M001', 'barang_nama' => 'Lipstick Matte', 'harga_beli' => 25000, 'harga_jual' => 40000],
            ['kategori_id' => 1, 'barang_kode' => 'M002', 'barang_nama' => 'Foundation Cushion', 'harga_beli' => 70000, 'harga_jual' => 120000],
            ['kategori_id' => 2, 'barang_kode' => 'B001', 'barang_nama' => 'Body Lotion Aloe Vera', 'harga_beli' => 20000, 'harga_jual' => 35000],
            ['kategori_id' => 2, 'barang_kode' => 'B002', 'barang_nama' => 'Shower Gel Lavender', 'harga_beli' => 30000, 'harga_jual' => 50000],
            ['kategori_id' => 3, 'barang_kode' => 'H001', 'barang_nama' => 'Shampoo Anti-Dandruff', 'harga_beli' => 30000, 'harga_jual' => 45000],
            ['kategori_id' => 3, 'barang_kode' => 'H002', 'barang_nama' => 'Hair Serum Keratin', 'harga_beli' => 50000, 'harga_jual' => 80000],
            ['kategori_id' => 4, 'barang_kode' => 'S001', 'barang_nama' => 'Sunscreen SPF 50+', 'harga_beli' => 60000, 'harga_jual' => 100000],
            ['kategori_id' => 4, 'barang_kode' => 'S002', 'barang_nama' => 'Face Wash Green Tea', 'harga_beli' => 25000, 'harga_jual' => 40000],
            ['kategori_id' => 5, 'barang_kode' => 'N001', 'barang_nama' => 'Nail Polish Red', 'harga_beli' => 15000, 'harga_jual' => 30000],
            ['kategori_id' => 5, 'barang_kode' => 'N002', 'barang_nama' => 'Cuticle Oil', 'harga_beli' => 20000, 'harga_jual' => 35000],
        ];
        DB::table('m_barang')->insert($data);
    }
}
