<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dokumen', function (Blueprint $table) {
            $table->string('id_dokumen', 7)->primary();
            $table->string('id_data', 4)->nullable();
            $table->string('id_tahap', 4)->nullable();
            $table->string('nama_dokumen', 100)->nullable();
            $table->text('isi')->nullable();

            //Key Constraint
            $table->foreign('id_data')->references('id_data')->on('data')->onDelete('cascade');
            $table->foreign('id_tahap')->references('id_tahap')->on('tahap')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen');
    }
};
