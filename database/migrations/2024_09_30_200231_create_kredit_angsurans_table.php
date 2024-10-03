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
