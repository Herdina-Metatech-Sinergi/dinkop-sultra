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
        Schema::table('kredits', function (Blueprint $table) {
            //
            $table->integer('administrasi_persen')->nullable();
            $table->integer('administrasi_rupiah')->nullable();
            $table->integer('cadangan')->nullable();
            $table->integer('nominal_bayar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kredits', function (Blueprint $table) {
            //
            $table->dropColumn('administrasi_persen');
            $table->dropColumn('administrasi_rupiah');
            $table->dropColumn('cadangan');
            $table->dropColumn('nominal_bayar');
        });
    }
};
