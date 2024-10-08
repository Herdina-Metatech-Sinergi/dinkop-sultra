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
        Schema::create('simpanan_non_modal_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained('simpanan_non_modal_menus');
            $table->foreignId('anggota_koperasi_id')->constrained('anggota_koperasis');
            $table->integer('nominal');
            $table->date('tanggal');
            $table->string('deskripsi')->nullable();
            $table->enum('d_k', ['Debet', 'Kredit']);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('simpanan_non_modal_data');
    }
};
