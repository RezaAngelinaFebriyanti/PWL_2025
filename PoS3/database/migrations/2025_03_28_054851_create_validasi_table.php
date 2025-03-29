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
        Schema::create('validasi', function (Blueprint $table) {
            $table->string('id_validasi', 5)->primary();
            $table->string('id_koor', 5)->nullable();
            $table->string('id_dokumen', 7)->nullable();
            $table->enum('status', ['disetujui', 'ditolak'])->nullable();

            //Key Constraint
            $table->foreign('id_koor')->references('id_koor')->on('koordinator')->onDelete('cascade');
            $table->foreign('id_dokumen')->references('id_dokumen')->on('dokumen')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('validasi');
    }
};
