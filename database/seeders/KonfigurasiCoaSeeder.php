<?php

namespace Database\Seeders;

use App\Models\Konfigurasi_coa;
use App\Models\KonfigurasiCOA;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KonfigurasiCoaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        KonfigurasiCOA::create([
            'nama' => 'Bayar Simpanan Wajib',
            'akun' => '1101',
            'persen' => '100',
            'd_k' => 'debet',
        ]);

        KonfigurasiCOA::create([
            'nama' => 'Bayar Simpanan Wajib',
            'akun' => '32',
            'persen' => '100',
            'd_k' => 'kredit',
        ]);

        KonfigurasiCOA::create([
            'nama' => 'Bayar Simpanan Wajib Tarik',
            'akun' => '32',
            'persen' => '100',
            'd_k' => 'debet',
        ]);

        KonfigurasiCOA::create([
            'nama' => 'Bayar Simpanan Wajib Tarik',
            'akun' => '1101',
            'persen' => '100',
            'd_k' => 'kredit',
        ]);

        KonfigurasiCOA::create([
            'nama' => 'Bayar Simpanan Non Modal',
            'akun' => '1101',
            'persen' => '100',
            'd_k' => 'debet',
        ]);

        KonfigurasiCOA::create([
            'nama' => 'Bayar Simpanan Non Modal',
            'akun' => '33',
            'persen' => '100',
            'd_k' => 'kredit',
        ]);

        KonfigurasiCOA::create([
            'nama' => 'Bayar Simpanan Non Modal Tarik',
            'akun' => '33',
            'persen' => '100',
            'd_k' => 'debet',
        ]);

        KonfigurasiCOA::create([
            'nama' => 'Bayar Simpanan Non Modal Tarik',
            'akun' => '1101',
            'persen' => '100',
            'd_k' => 'kredit',
        ]);


        // KonfigurasiCOA::create([
        //     'nama' => 'Bayar Angsuran Kredit',
        //     'akun' => '1101',
        //     'persen' => '100',
        //     'd_k' => 'debet',
        // ]);

        // KonfigurasiCOA::create([
        //     'nama' => 'Bayar Angsuran Kredit',
        //     'akun' => '1108',
        //     'persen' => '100',
        //     'd_k' => 'kredit',
        // ]);


        KonfigurasiCOA::create([
            'nama' => 'Bayar Simpanan Pokok',
            'akun' => '1101',
            'persen' => '100',
            'd_k' => 'debet',
        ]);

        KonfigurasiCOA::create([
            'nama' => 'Bayar Simpanan Pokok',
            'akun' => '31',
            'persen' => '100',
            'd_k' => 'kredit',
        ]);

        KonfigurasiCOA::create([
            'nama' => 'Bayar Simpanan Pokok Tarik',
            'akun' => '31',
            'persen' => '100',
            'd_k' => 'debet',
        ]);

        KonfigurasiCOA::create([
            'nama' => 'Bayar Simpanan Pokok Tarik',
            'akun' => '1101',
            'persen' => '100',
            'd_k' => 'kredit',
        ]);

        KonfigurasiCOA::create([
            'nama' => 'Pinjam',
            'akun' => '1101',
            'persen' => '100',
            'd_k' => 'debet',
        ]);

        KonfigurasiCOA::create([
            'nama' => 'Pinjam',
            'akun' => '2101',
            'persen' => '100',
            'd_k' => 'kredit',
        ]);

        KonfigurasiCOA::create([
            'nama' => 'Bayar Pinjaman Pokok',
            'akun' => '2101',
            'persen' => '100',
            'd_k' => 'debet',
        ]);

        KonfigurasiCOA::create([
            'nama' => 'Bayar Pinjaman Pokok',
            'akun' => '1101',
            'persen' => '100',
            'd_k' => 'kredit',
        ]);

        KonfigurasiCOA::create([
            'nama' => 'Bayar Pinjaman Jasa',
            'akun' => '4101',
            'persen' => '100',
            'd_k' => 'debet',
        ]);

        KonfigurasiCOA::create([
            'nama' => 'Bayar Pinjaman Jasa',
            'akun' => '1101',
            'persen' => '100',
            'd_k' => 'kredit',
        ]);


    }
}
