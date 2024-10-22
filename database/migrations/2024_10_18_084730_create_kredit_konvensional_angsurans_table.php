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
        Schema::create('kredit_konvensional_angsurans', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('kredit_konvensional_id');
            $table->foreign('kredit_konvensional_id')->references('id')->on('kredit_konvensionals')->onDelete('cascade');
            $table->integer('angsuran_ke');
            $table->date('tanggal_jatuh_tempo');
            $table->integer('jumlah_hari'); // Jumlah hari antara pembayaran
            $table->decimal('pokok', 15, 2); // Pokok pada angsuran tersebut
            $table->decimal('jumlah_angsuran', 15, 2); // Jumlah total angsuran (pokok + bunga)
            $table->decimal('angsuran_pokok', 15, 2); // Angsuran pokok
            $table->decimal('angsuran_bunga', 15, 2); // Angsuran bunga
            $table->decimal('baki_debet', 15, 2); // Sisa saldo
            $table->string('status_pokok')->default('Belum Lunas');  // Default to "Belum Lunas"
            $table->string('status_bunga')->default('Belum Lunas');  // Default to "Belum Lunas"

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kredit_konvensional_angsurans');
    }
};
