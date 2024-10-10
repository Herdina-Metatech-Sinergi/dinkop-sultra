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
        Schema::create('transaksi_umums', function (Blueprint $table) {
            $table->id();
            $table->foreignId('identitas_koperasi_id')->constrained('identitas_koperasis');
            $table->string('konfigurasi_coa');
            $table->string('tanggal')->nullable();
            $table->integer('nominal')->nullable();
            $table->string('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_umums');
    }
};
