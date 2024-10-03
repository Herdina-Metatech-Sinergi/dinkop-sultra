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
        Schema::create('anggota_koperasis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('identitas_koperasi_id')->nullable(); // kolom foreign key
            $table->foreign('identitas_koperasi_id')->references('id')->on('identitas_koperasis');
            $table->string('no_anggota')->unique();
            $table->string('nama')->nullable();
            $table->string('alamat')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('email')->nullable();
            $table->string('ktp')->nullable();
            $table->date('tgl_masuk')->nullable();
            $table->date('tgl_keluar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggota_koperasis');
    }
};
