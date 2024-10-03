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
        Schema::create('kredits', function (Blueprint $table) {
            $table->id();
            $table->string('kredit');
            $table->string('keterangan')->nullable();
            $table->integer('nominal_pinjaman')->nullable();
            $table->integer('dp')->nullable();
            $table->integer('nominal_pinjaman_margin')->nullable();
            $table->integer('tenor')->default(1);
            $table->unsignedBigInteger('anggota_koperasi_id');
            $table->foreign('anggota_koperasi_id')->references('id')->on('anggota_koperasis')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kredits');
    }
};
