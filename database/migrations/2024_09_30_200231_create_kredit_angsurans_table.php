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
        Schema::create('kredit_angsurans', function (Blueprint $table) {
            $table->id();
            $table->date('tgl')->nullable();
            $table->string('angsuran')->nullable();
            $table->string('status')->default('Belum Lunas');
            $table->integer('nominal')->nullable();
            $table->unsignedBigInteger('kredit_id');
            $table->foreign('kredit_id')->references('id')->on('kredits')->onDelete('cascade');

            $table->integer('angsuran_ke')->nullable();  // Installment number
            $table->decimal('nominal_pokok', 15, 2)->nullable();  // Principal installment
            $table->decimal('nominal_bunga', 15, 2)->nullable();  // Interest installment
            $table->decimal('jumlah_angsuran', 15, 2)->nullable();  // Total installment (Pokok + Bunga)
            $table->decimal('baki_debet', 15, 2)->nullable();  // Remaining balance after payment

            $table->date('tanggal_jatuh_tempo')->nullable();
            $table->string('status_pokok')->default('Belum Lunas');  // Default to "Belum Lunas"
            $table->string('status_bunga')->default('Belum Lunas');  // Default to "Belum Lunas"

            // Remove unnecessary columns (if applicable)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::dropIfExists('kredit_angsurans');
    }
};
