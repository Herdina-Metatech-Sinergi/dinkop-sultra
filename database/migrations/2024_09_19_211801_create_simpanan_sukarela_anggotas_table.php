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
        Schema::create('simpanan_sukarela_anggotas', function (Blueprint $table) {
            $table->id();
            $table->string('tanggal')->nullable();
            $table->integer('nominal')->nullable();
            $table->string('d_k')->default('debet');
            $table->string('deskripsi')->nullable();
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
        Schema::dropIfExists('simpanan_sukarela_anggotas');
    }
};
