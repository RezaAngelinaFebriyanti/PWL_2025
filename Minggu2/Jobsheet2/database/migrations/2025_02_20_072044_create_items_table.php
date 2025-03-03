<?php

//Deklarasi Namespace dan Dependensi
use Illuminate\Database\Migrations\Migration; //Mengimpor kelas Migration untuk semua migrasi Laravel
use Illuminate\Database\Schema\Blueprint; //Mengimpor kelas Blueprint untuk menentukan skema tabel
use Illuminate\Support\Facades\Schema; //Mengimpor facade Schema untuk mengelola skema database

return new class extends Migration //digunakan untuk mengatur dan menghapus tabel
{
    /**
     * Run the migrations.
     */

    //Fungsi untuk mengubah skema database
    public function up(): void
    {
        //Untuk membuat tabel baru
        Schema::create('items', function (Blueprint $table) {
            $table->id(); // Menambahkan kolom id ke tabel
            //Tambahan Kode
            $table->string('name'); //Menambahkan nama id ke tabel
            $table->text('description'); //Menambahkan description id ke tabel
            $table->timestamps(); //Menambahkan waktu
        });
    }

    /**
     * Reverse the migrations.
     */
    
    //Fungsi untuk mengcancel fungsi up
    public function down(): void
    {
        Schema::dropIfExists('items'); //menghapus tabel items
    }
};