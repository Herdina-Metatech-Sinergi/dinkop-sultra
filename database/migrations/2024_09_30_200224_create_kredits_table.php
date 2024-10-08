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

            $table->dropColumn(['nominal_pinjaman_margin', 'dp']);

            // Add new columns matching the Excel structure
            $table->decimal('interest_rate', 5, 2)->nullable();
            $table->integer('num_installments')->nullable();
            $table->decimal('principal', 15, 2)->nullable(); // Represents the original loan amount
            $table->decimal('total_installment', 15, 2)->nullable(); // Total of each installment (Pokok + Bunga)

            $table->decimal('angsuran_bulan', 15, 2)->nullable();

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
