<?php

namespace Database\Seeders;

use App\Http\Controllers\Controller;
use App\Models\AnggotaKoperasi;
use App\Models\SimpananWajibAnggota;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SimpananWajibTrialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $anggotakop = AnggotaKoperasi::get();
        foreach ($anggotakop as $key => $value) {
            # code...
            $nominal = 50000;

            $tgl = '2024-01-23';
            $data = [
                'tanggal' => $tgl,
                'nominal' => $nominal,
                'd_k' => 'Kredit',
                'deskripsi' => 'Keluar dari Anggota Koperasi',
                'anggota_koperasi_id' => $value->id
            ];

            $simpok = SimpananWajibAnggota::create($data);

            $controller = new Controller();
            $controller->jurnal_umum('Bayar Simpanan Wajib',$nominal,$value->id,null,null,$simpok->tanggal);

            $tgl = '2024-02-03';
            $data = [
                'tanggal' => $tgl,
                'nominal' => $nominal,
                'd_k' => 'Kredit',
                'deskripsi' => 'Keluar dari Anggota Koperasi',
                'anggota_koperasi_id' => $value->id
            ];

            $simpok = SimpananWajibAnggota::create($data);

            $controller = new Controller();
            $controller->jurnal_umum('Bayar Simpanan Wajib',$nominal,$value->id,null,null,$simpok->tanggal);

            $tgl = '2024-03-04';
            $data = [
                'tanggal' => $tgl,
                'nominal' => $nominal,
                'd_k' => 'Kredit',
                'deskripsi' => 'Keluar dari Anggota Koperasi',
                'anggota_koperasi_id' => $value->id
            ];

            $simpok = SimpananWajibAnggota::create($data);

            $controller = new Controller();
            $controller->jurnal_umum('Bayar Simpanan Wajib',$nominal,$value->id,null,null,$simpok->tanggal);


            $tgl = '2024-04-05';
            $data = [
                'tanggal' => $tgl,
                'nominal' => $nominal,
                'd_k' => 'Kredit',
                'deskripsi' => 'Keluar dari Anggota Koperasi',
                'anggota_koperasi_id' => $value->id
            ];

            $simpok = SimpananWajibAnggota::create($data);

            $controller = new Controller();
            $controller->jurnal_umum('Bayar Simpanan Wajib',$nominal,$value->id,null,null,$simpok->tanggal);

            $tgl = '2024-05-05';
            $data = [
                'tanggal' => $tgl,
                'nominal' => $nominal,
                'd_k' => 'Kredit',
                'deskripsi' => 'Keluar dari Anggota Koperasi',
                'anggota_koperasi_id' => $value->id
            ];

            $simpok = SimpananWajibAnggota::create($data);

            $controller = new Controller();
            $controller->jurnal_umum('Bayar Simpanan Wajib',$nominal,$value->id,null,null,$simpok->tanggal);

            $tgl = '2024-06-08';
            $data = [
                'tanggal' => $tgl,
                'nominal' => $nominal,
                'd_k' => 'Kredit',
                'deskripsi' => 'Keluar dari Anggota Koperasi',
                'anggota_koperasi_id' => $value->id
            ];

            $simpok = SimpananWajibAnggota::create($data);

            $controller = new Controller();
            $controller->jurnal_umum('Bayar Simpanan Wajib',$nominal,$value->id,null,null,$simpok->tanggal);

            $tgl = '2024-07-06';
            $data = [
                'tanggal' => $tgl,
                'nominal' => $nominal,
                'd_k' => 'Kredit',
                'deskripsi' => 'Keluar dari Anggota Koperasi',
                'anggota_koperasi_id' => $value->id
            ];

            $simpok = SimpananWajibAnggota::create($data);

            $controller = new Controller();
            $controller->jurnal_umum('Bayar Simpanan Wajib',$nominal,$value->id,null,null,$simpok->tanggal);

            $tgl = '2024-08-04';
            $data = [
                'tanggal' => $tgl,
                'nominal' => $nominal,
                'd_k' => 'Kredit',
                'deskripsi' => 'Keluar dari Anggota Koperasi',
                'anggota_koperasi_id' => $value->id
            ];

            $simpok = SimpananWajibAnggota::create($data);

            $controller = new Controller();
            $controller->jurnal_umum('Bayar Simpanan Wajib',$nominal,$value->id,null,null,$simpok->tanggal);


            $tgl = '2024-09-16';
            $data = [
                'tanggal' => $tgl,
                'nominal' => $nominal,
                'd_k' => 'Kredit',
                'deskripsi' => 'Keluar dari Anggota Koperasi',
                'anggota_koperasi_id' => $value->id
            ];

            $simpok = SimpananWajibAnggota::create($data);

            $controller = new Controller();
            $controller->jurnal_umum('Bayar Simpanan Wajib',$nominal,$value->id,null,null,$simpok->tanggal);

            $tgl = '2024-10-07';
            $data = [
                'tanggal' => $tgl,
                'nominal' => $nominal,
                'd_k' => 'Kredit',
                'deskripsi' => 'Keluar dari Anggota Koperasi',
                'anggota_koperasi_id' => $value->id
            ];

            $simpok = SimpananWajibAnggota::create($data);

            $controller = new Controller();
            $controller->jurnal_umum('Bayar Simpanan Wajib',$nominal,$value->id,null,null,$simpok->tanggal);
        }
    }
}
