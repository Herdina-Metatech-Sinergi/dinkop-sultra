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
        Schema::create('kredit_konvensionals', function (Blueprint $table) {
            $table->id();
            $table->string('kredit');
            $table->bigInteger('pinjaman_pokok');
            $table->integer('jangka_waktu'); // dalam bulan
            $table->float('tarif_layanan'); // dalam persen
            $table->decimal('angsuran_pokok_pertama', 15, 2);
            $table->decimal('angsuran_pokok_berikutnya', 15, 2);
            $table->date('tanggal_mulai');
            $table->date('tanggal_jatuh_tempo_pertama');

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
        Schema::dropIfExists('kredit_konvensionals');
    }
};
