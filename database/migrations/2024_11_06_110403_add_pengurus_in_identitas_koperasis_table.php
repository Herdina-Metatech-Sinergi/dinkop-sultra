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
        Schema::table('identitas_koperasis', function (Blueprint $table) {
            //
            $table->string('nama_sekretaris')->nullable();
            $table->string('nama_bendahara')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('identitas_koperasis', function (Blueprint $table) {
            //
        });
    }
};
