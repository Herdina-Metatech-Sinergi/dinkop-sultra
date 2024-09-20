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
        Schema::create('master_coas', function (Blueprint $table) {
            $table->id();
            $table->treeColumns();
            $table->string('kode_coa')->nullable();
            $table->string('kelompok')->nullable();
            $table->string('saldo_normal')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_coas');
    }
};
