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
        Schema::create('jurnal_umums', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->nullable();
            $table->string('jurnal')->nullable();
            $table->string('deskripsi')->nullable();
            $table->string('akun')->nullable();
            $table->string('d_k')->nullable();
            $table->double('nominal')->nullable();
            $table->unsignedBigInteger('identitas_koperasi_id')->nullable(); // kolom foreign key
            $table->foreign('identitas_koperasi_id')->references('id')->on('identitas_koperasis');
            $table->unsignedBigInteger('user_id'); // kolom foreign key
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurnal_umums');
    }
};
