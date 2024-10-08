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
        Schema::create('simpanan_non_modal_menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('identitas_koperasi_id')->constrained('identitas_koperasis');
            $table->string('nama_menu');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('simpanan_non_modal_menus');
    }
};
