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
        Schema::create('master_bagian_s_h_u_s', function (Blueprint $table) {
            $table->id();
            $table->decimal('total_shu', 15, 2)->comment('Total SHU koperasi');
            $table->decimal('shu_bagian_anggota', 5, 2)->comment('% SHU bagian anggota');
            $table->decimal('simpanan_anggota', 15, 2)->comment('Simpanan anggota yang bersangkutan');
            $table->decimal('total_simpanan_anggota', 15, 2)->comment('Total simpanan seluruh anggota');
            $table->decimal('transaksi_anggota', 15, 2)->comment('Transaksi anggota yang bersangkutan');
            $table->decimal('total_transaksi_anggota', 15, 2)->comment('Total transaksi seluruh anggota');
            $table->decimal('shu_untuk_simpanan', 5, 2)->comment('% SHU untuk simpanan');
            $table->decimal('shu_untuk_transaksi', 5, 2)->comment('% SHU untuk transaksi anggota');

            $table->unsignedBigInteger('identitas_koperasi_id')->nullable(); // kolom foreign key
            $table->foreign('identitas_koperasi_id')->references('id')->on('identitas_koperasis');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_bagian_s_h_u_s');
    }
};
