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
        Schema::create('identitas_koperasis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_koperasi')->nullable();
            $table->string('no_badan_hukum')->nullable();
            $table->date('tgl_badan_hukum')->nullable();
            $table->string('nomor_pad_terakhir')->nullable();
            $table->date('tgl_pad')->nullable();
            $table->text('alamat')->nullable();
            $table->string('jalan')->nullable();
            $table->string('desa_kelurahan')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kabupaten_kota')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('nama_pengurus')->nullable();
            $table->string('nama_pengawas')->nullable();
            $table->string('telp_fax_email')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->string('npwp_koperasi')->nullable();
            $table->string('nomor_rekening_nama_koperasi')->nullable();
            $table->string('bentuk_koperasi')->nullable();
            $table->string('jenis_koperasi')->nullable();
            $table->string('nomor_induk_koperasi_nik')->nullable();
            $table->string('iusp')->nullable();
            $table->date('tgl_iusp')->nullable();
            $table->string('nib')->nullable();
            $table->date('tgl_nib')->nullable();
            $table->integer('jumlah_anggota_pria')->nullable();
            $table->integer('jumlah_anggota_wanita')->nullable();
            $table->integer('jumlah_kantor_cabang')->nullable();
            $table->string('status')->default('Menunggu');
            $table->string('nama_simpanan_lainnya')->default('Simpanan Lainnya');
            $table->unsignedBigInteger('user_id')->nullable(); // kolom foreign key
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('identitas_koperasis');
    }
};
