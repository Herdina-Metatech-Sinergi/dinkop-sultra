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
        Schema::table('master_bagian_s_h_u_s', function (Blueprint $table) {
            //
            $table->decimal('cadangan', 5, 2)->nullable(); // % Cadangan
            $table->decimal('dana_pendidikan', 5, 2)->nullable(); // % Dana Pendidikan
            $table->decimal('insentif_pengurus_pengawas', 5, 2)->nullable(); // % Insentif Pengurus Pengawas
            $table->decimal('insentif_pengelola', 5, 2)->nullable(); // % Insentif Pengelola
            $table->decimal('dana_sosial', 5, 2)->nullable(); // % Dana Sosial
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_bagian_s_h_u_s', function (Blueprint $table) {
            //
            $table->decimal('cadangan', 5, 2); // Mengembalikan % Cadangan
            $table->decimal('dana_pendidikan', 5, 2); // Mengembalikan % Dana Pendidikan
            $table->decimal('insentif_pengurus_pengawas', 5, 2); // Mengembalikan % Insentif Pengurus Pengawas
            $table->decimal('insentif_pengelola', 5, 2); // Mengembalikan % Insentif Pengelola
            $table->decimal('dana_sosial', 5, 2); // Mengembalikan % Dana Sosial
        });
    }
};
