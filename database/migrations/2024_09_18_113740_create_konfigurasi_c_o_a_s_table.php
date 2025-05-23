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
        Schema::create('konfigurasi_c_o_a_s', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->string('akun')->nullable();
            $table->string('d_k')->nullable();
            $table->integer('persen')->default(100)->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konfigurasi_c_o_a_s');
    }
};
