<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterCOASeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('master_coas')->insert([
            ['id' => 1, 'title' => 'ASET / AKTIVA', 'parent_id' => -1, 'order' => 1, 'kode_coa' => '1', 'kelompok' => 'ASET / AKTIVA', 'saldo_normal' => 'Debet'],
            ['id' => 2, 'title' => 'ASET LANCAR', 'parent_id' => 1, 'order' => 1, 'kode_coa' => '11', 'kelompok' => 'ASET LANCAR', 'saldo_normal' => 'Debet'],
            ['id' => 3, 'title' => 'Kas', 'parent_id' => 2, 'order' => 1, 'kode_coa' => '1101', 'kelompok' => 'Kas', 'saldo_normal' => 'Debet'],
            ['id' => 4, 'title' => 'Giro', 'parent_id' => 2, 'order' => 2, 'kode_coa' => '1102', 'kelompok' => 'Giro', 'saldo_normal' => 'Debet'],
            ['id' => 5, 'title' => 'Tabungan', 'parent_id' => 2, 'order' => 3, 'kode_coa' => '1103', 'kelompok' => 'Tabungan', 'saldo_normal' => 'Debet'],
            ['id' => 6, 'title' => 'Deposito', 'parent_id' => 2, 'order' => 4, 'kode_coa' => '1104', 'kelompok' => 'Deposito', 'saldo_normal' => 'Debet'],
            ['id' => 7, 'title' => 'Simpanan Sukarela pada koperasi lain', 'parent_id' => 2, 'order' => 5, 'kode_coa' => '1105', 'kelompok' => 'Simpanan Sukarela pada koperasi lain', 'saldo_normal' => 'Debet'],
            ['id' => 8, 'title' => 'Simpanan Berjangka pada koperasi lain', 'parent_id' => 2, 'order' => 6, 'kode_coa' => '1106', 'kelompok' => 'Simpanan Berjangka pada koperasi lain', 'saldo_normal' => 'Debet'],
            ['id' => 9, 'title' => 'Surat Berharga (Investasi Jangka Pendek)', 'parent_id' => 2, 'order' => 7, 'kode_coa' => '1107', 'kelompok' => 'Surat Berharga (Investasi Jangka Pendek)', 'saldo_normal' => 'Debet'],
            ['id' => 10, 'title' => 'Piutang anggota', 'parent_id' => 2, 'order' => 8, 'kode_coa' => '1108', 'kelompok' => 'Piutang anggota', 'saldo_normal' => 'Debet'],
            ['id' => 11, 'title' => 'Piutang pada calon anggota', 'parent_id' => 2, 'order' => 9, 'kode_coa' => '1109', 'kelompok' => 'Piutang pada calon anggota', 'saldo_normal' => 'Debet'],
            ['id' => 12, 'title' => 'Piutang Bunga', 'parent_id' => 2, 'order' => 10, 'kode_coa' => '1110', 'kelompok' => 'Piutang Bunga', 'saldo_normal' => 'Debet'],
            ['id' => 13, 'title' => 'Piutang Lainnya', 'parent_id' => 2, 'order' => 11, 'kode_coa' => '1111', 'kelompok' => 'Piutang Lainnya', 'saldo_normal' => 'Debet'],
            ['id' => 14, 'title' => 'Penyisihan Piutang / Piutang Tak Tertagih', 'parent_id' => 2, 'order' => 12, 'kode_coa' => '1112', 'kelompok' => 'Penyisihan Piutang / Piutang Tak Tertagih', 'saldo_normal' => 'Debet'],
            ['id' => 15, 'title' => 'Premi Asuransi', 'parent_id' => 2, 'order' => 13, 'kode_coa' => '1113', 'kelompok' => 'Premi Asuransi', 'saldo_normal' => 'Debet'],
            ['id' => 16, 'title' => 'Perlengkapan Kantor', 'parent_id' => 2, 'order' => 14, 'kode_coa' => '1114', 'kelompok' => 'Perlengkapan Kantor', 'saldo_normal' => 'Debet'],
            ['id' => 17, 'title' => 'Beban Dibayar Dimuka', 'parent_id' => 2, 'order' => 15, 'kode_coa' => '1115', 'kelompok' => 'Beban Dibayar Dimuka', 'saldo_normal' => 'Debet'],
            ['id' => 18, 'title' => 'Pendapatan Yang Masih Harus Diterima', 'parent_id' => 2, 'order' => 16, 'kode_coa' => '1116', 'kelompok' => 'Pendapatan Yang Masih Harus Diterima', 'saldo_normal' => 'Debet'],
            ['id' => 19, 'title' => 'Persediaan', 'parent_id' => 2, 'order' => 17, 'kode_coa' => '1117', 'kelompok' => 'Persediaan', 'saldo_normal' => 'Debet'],
            ['id' => 20, 'title' => 'Aset Lancar Lainnya', 'parent_id' => 2, 'order' => 18, 'kode_coa' => '1119', 'kelompok' => 'Aset Lancar Lainnya', 'saldo_normal' => 'Debet'],

            ['id' => 21, 'title' => 'ASET TIDAK LANCAR', 'parent_id' => 1, 'order' => 2, 'kode_coa' => '12', 'kelompok' => 'ASET TIDAK LANCAR', 'saldo_normal' => 'Debet'],
            ['id' => 22, 'title' => 'Investasi Jangka Panjang', 'parent_id' => 21, 'order' => 1, 'kode_coa' => '1201', 'kelompok' => 'Investasi Jangka Panjang', 'saldo_normal' => 'Debet'],
            ['id' => 23, 'title' => 'Investasi Berbunga Berjangka', 'parent_id' => 21, 'order' => 2, 'kode_coa' => '1202', 'kelompok' => 'Investasi Berbunga Berjangka', 'saldo_normal' => 'Debet'],
            ['id' => 24, 'title' => 'Surat Berharga', 'parent_id' => 21, 'order' => 3, 'kode_coa' => '1203', 'kelompok' => 'Surat Berharga', 'saldo_normal' => 'Debet'],
            ['id' => 25, 'title' => 'Simpanan di KSP Lain', 'parent_id' => 21, 'order' => 4, 'kode_coa' => '1204', 'kelompok' => 'Simpanan di KSP Lain', 'saldo_normal' => 'Debet'],
            ['id' => 26, 'title' => 'Simpanan Berjangka pada Lembaga Keuangan', 'parent_id' => 21, 'order' => 5, 'kode_coa' => '1205', 'kelompok' => 'Simpanan Berjangka pada Lembaga Keuangan', 'saldo_normal' => 'Debet'],
            ['id' => 27, 'title' => 'Penyertaan pada Lembaga Lainnya', 'parent_id' => 21, 'order' => 6, 'kode_coa' => '1206', 'kelompok' => 'Penyertaan pada Lembaga Lainnya', 'saldo_normal' => 'Debet'],
            ['id' => 28, 'title' => 'Properti Investasi', 'parent_id' => 21, 'order' => 7, 'kode_coa' => '1207', 'kelompok' => 'Properti Investasi', 'saldo_normal' => 'Debet'],
            ['id' => 29, 'title' => 'Akumulasi Penyusutan Properti Investasi', 'parent_id' => 21, 'order' => 8, 'kode_coa' => '1208', 'kelompok' => 'Akumulasi Penyusutan Properti Investasi', 'saldo_normal' => 'Kredit'],

            ['id' => 30, 'title' => 'ASET TETAP', 'parent_id' => 1, 'order' => 3, 'kode_coa' => '1204', 'kelompok' => 'ASET TETAP', 'saldo_normal' => 'Debet'],
            ['id' => 31, 'title' => 'Tanah', 'parent_id' => 30, 'order' => 1, 'kode_coa' => '12041', 'kelompok' => 'Tanah', 'saldo_normal' => 'Debet'],
            ['id' => 32, 'title' => 'Bangunan', 'parent_id' => 30, 'order' => 2, 'kode_coa' => '12042', 'kelompok' => 'Bangunan', 'saldo_normal' => 'Debet'],
            ['id' => 33, 'title' => 'Mesin dan Kendaraan', 'parent_id' => 30, 'order' => 3, 'kode_coa' => '12043', 'kelompok' => 'Mesin dan Kendaraan', 'saldo_normal' => 'Debet'],
            ['id' => 34, 'title' => 'Inventaris dan Peralatan Kantor', 'parent_id' => 30, 'order' => 4, 'kode_coa' => '12044', 'kelompok' => 'Inventaris dan Peralatan Kantor', 'saldo_normal' => 'Debet'],
            ['id' => 35, 'title' => 'Akumulasi Penyusutan Aset Tetap', 'parent_id' => 30, 'order' => 5, 'kode_coa' => '12045', 'kelompok' => 'Akumulasi Penyusutan Aset Tetap', 'saldo_normal' => 'Kredit'],

            ['id' => 36, 'title' => 'ASET LAINNYA', 'parent_id' => 1, 'order' => 4, 'kode_coa' => '13', 'kelompok' => 'ASET LAINNYA', 'saldo_normal' => 'Debet'],
            ['id' => 37, 'title' => 'Aset Tidak Berwujud', 'parent_id' => 36, 'order' => 1, 'kode_coa' => '1301', 'kelompok' => 'Aset Tidak Berwujud', 'saldo_normal' => 'Debet'],
            ['id' => 38, 'title' => 'Beban ditangguhkan', 'parent_id' => 36, 'order' => 2, 'kode_coa' => '1302', 'kelompok' => 'Beban ditangguhkan', 'saldo_normal' => 'Debet'],
            ['id' => 39, 'title' => 'Agunan Yang Diambil Alih', 'parent_id' => 36, 'order' => 3, 'kode_coa' => '1303', 'kelompok' => 'Agunan Yang Diambil Alih', 'saldo_normal' => 'Debet'],
            ['id' => 40, 'title' => 'Biaya Pra Operasional', 'parent_id' => 36, 'order' => 4, 'kode_coa' => '1304', 'kelompok' => 'Biaya Pra Operasional', 'saldo_normal' => 'Debet'],
            ['id' => 41, 'title' => 'Aset Lain-lain', 'parent_id' => 36, 'order' => 5, 'kode_coa' => '1305', 'kelompok' => 'Aset Lain-lain', 'saldo_normal' => 'Debet'],

            ['id' => 42, 'title' => 'KEWAJIBAN LANCAR', 'parent_id' => -1, 'order' => 2, 'kode_coa' => '21', 'kelompok' => 'KEWAJIBAN LANCAR', 'saldo_normal' => 'Kredit'],
            ['id' => 43, 'title' => 'Tabungan/simpanan anggota', 'parent_id' => 42, 'order' => 1, 'kode_coa' => '2101', 'kelompok' => 'Tabungan/simpanan anggota', 'saldo_normal' => 'Kredit'],
            ['id' => 44, 'title' => 'Tabungan/simpanan non anggota', 'parent_id' => 42, 'order' => 2, 'kode_coa' => '2102', 'kelompok' => 'Tabungan/simpanan non anggota', 'saldo_normal' => 'Kredit'],
            ['id' => 45, 'title' => 'Simpanan berjangka non anggota', 'parent_id' => 42, 'order' => 3, 'kode_coa' => '2103', 'kelompok' => 'Simpanan berjangka non anggota', 'saldo_normal' => 'Kredit'],
            ['id' => 46, 'title' => 'Simpanan berjangka calon anggota & koperasi lain', 'parent_id' => 42, 'order' => 4, 'kode_coa' => '2104', 'kelompok' => 'Simpanan berjangka calon anggota & koperasi lain', 'saldo_normal' => 'Kredit'],
            ['id' => 47, 'title' => 'Hutang Bank (Bagian jatuh tempo kurang 1 tahun)', 'parent_id' => 42, 'order' => 5, 'kode_coa' => '2105', 'kelompok' => 'Hutang Bank (Bagian jatuh tempo kurang 1 tahun)', 'saldo_normal' => 'Kredit'],
            ['id' => 48, 'title' => 'Hutang LPDB', 'parent_id' => 42, 'order' => 6, 'kode_coa' => '2106', 'kelompok' => 'Hutang LPDB', 'saldo_normal' => 'Kredit'],
            ['id' => 49, 'title' => 'Hutang Bank', 'parent_id' => 42, 'order' => 7, 'kode_coa' => '2107', 'kelompok' => 'Hutang Bank', 'saldo_normal' => 'Kredit'],
            ['id' => 50, 'title' => 'Titipan dana jangka panjang', 'parent_id' => 42, 'order' => 8, 'kode_coa' => '2108', 'kelompok' => 'Titipan dana jangka panjang', 'saldo_normal' => 'Kredit'],
            ['id' => 51, 'title' => 'Hutang Jangka Panjang Lain', 'parent_id' => 42, 'order' => 9, 'kode_coa' => '2109', 'kelompok' => 'Hutang Jangka Panjang Lain', 'saldo_normal' => 'Kredit'],

            ['id' => 52, 'title' => 'KEWAJIBAN JANGKA PANJANG', 'parent_id' => -1, 'order' => 3, 'kode_coa' => '22', 'kelompok' => 'KEWAJIBAN JANGKA PANJANG', 'saldo_normal' => 'Kredit'],
            ['id' => 53, 'title' => 'Hutang Bank (Jangka Panjang)', 'parent_id' => 52, 'order' => 1, 'kode_coa' => '2205', 'kelompok' => 'Hutang Bank (Jangka Panjang)', 'saldo_normal' => 'Kredit'],
            ['id' => 54, 'title' => 'Titipan dana jangka panjang', 'parent_id' => 52, 'order' => 2, 'kode_coa' => '2208', 'kelompok' => 'Titipan dana jangka panjang', 'saldo_normal' => 'Kredit'],
            ['id' => 55, 'title' => 'Hutang Bank (Bagian jatuh tempo lebih dari 1 tahun)', 'parent_id' => 52, 'order' => 3, 'kode_coa' => '2206', 'kelompok' => 'Hutang Bank (Bagian jatuh tempo lebih dari 1 tahun)', 'saldo_normal' => 'Kredit'],
            ['id' => 56, 'title' => 'Hutang Sewa Guna Usaha', 'parent_id' => 52, 'order' => 4, 'kode_coa' => '2207', 'kelompok' => 'Hutang Sewa Guna Usaha', 'saldo_normal' => 'Kredit'],

            ['id' => 57, 'title' => 'EKUITAS', 'parent_id' => -1, 'order' => 4, 'kode_coa' => '3', 'kelompok' => 'EKUITAS', 'saldo_normal' => 'Kredit'],
            ['id' => 58, 'title' => 'Simpanan Pokok', 'parent_id' => 57, 'order' => 1, 'kode_coa' => '31', 'kelompok' => 'Simpanan Pokok', 'saldo_normal' => 'Kredit'],
            ['id' => 59, 'title' => 'Simpanan Wajib', 'parent_id' => 57, 'order' => 2, 'kode_coa' => '32', 'kelompok' => 'Simpanan Wajib', 'saldo_normal' => 'Kredit'],
            ['id' => 60, 'title' => 'Simpanan Khusus/Simp. Lainnya', 'parent_id' => 57, 'order' => 3, 'kode_coa' => '33', 'kelompok' => 'Simpanan Khusus/Simp. Lainnya', 'saldo_normal' => 'Kredit'],
            ['id' => 61, 'title' => 'Modal Penyertaan', 'parent_id' => 57, 'order' => 4, 'kode_coa' => '34', 'kelompok' => 'Modal Penyertaan', 'saldo_normal' => 'Kredit'],
            ['id' => 62, 'title' => 'Cadangan Umum', 'parent_id' => 57, 'order' => 5, 'kode_coa' => '35', 'kelompok' => 'Cadangan Umum', 'saldo_normal' => 'Kredit'],
            ['id' => 63, 'title' => 'Cadangan Tujuan Resiko', 'parent_id' => 57, 'order' => 6, 'kode_coa' => '36', 'kelompok' => 'Cadangan Tujuan Resiko', 'saldo_normal' => 'Kredit'],
            ['id' => 64, 'title' => 'SHU periode berjalan', 'parent_id' => 57, 'order' => 7, 'kode_coa' => '37', 'kelompok' => 'SHU periode berjalan', 'saldo_normal' => 'Kredit'],

            ['id' => 65, 'title' => 'PENDAPATAN', 'parent_id' => -1, 'order' => 5, 'kode_coa' => '4', 'kelompok' => 'PENDAPATAN', 'saldo_normal' => 'Kredit'],
            ['id' => 66, 'title' => 'PARTISIPASI BRUTO ANGGOTA', 'parent_id' => 65, 'order' => 1, 'kode_coa' => '41', 'kelompok' => 'PARTISIPASI BRUTO ANGGOTA', 'saldo_normal' => 'Kredit'],
            ['id' => 67, 'title' => 'Pendapatan Jasa Pinjaman anggota', 'parent_id' => 66, 'order' => 1, 'kode_coa' => '4101', 'kelompok' => 'Pendapatan Jasa Pinjaman anggota', 'saldo_normal' => 'Kredit'],
            ['id' => 68, 'title' => 'Pendapatan Administrasi Anggota', 'parent_id' => 66, 'order' => 2, 'kode_coa' => '4102', 'kelompok' => 'Pendapatan Administrasi Anggota', 'saldo_normal' => 'Kredit'],
            ['id' => 69, 'title' => 'Pendapatan Provisi Anggota', 'parent_id' => 66, 'order' => 3, 'kode_coa' => '4103', 'kelompok' => 'Pendapatan Provisi Anggota', 'saldo_normal' => 'Kredit'],
            ['id' => 70, 'title' => 'Pendapatan Jasa Pelayanan Lainnya anggota', 'parent_id' => 66, 'order' => 4, 'kode_coa' => '4104', 'kelompok' => 'Pendapatan Jasa Pelayanan Lainnya anggota', 'saldo_normal' => 'Kredit'],

            ['id' => 71, 'title' => 'PENDAPATAN NON ANGGOTA', 'parent_id' => 65, 'order' => 2, 'kode_coa' => '42', 'kelompok' => 'PENDAPATAN NON ANGGOTA', 'saldo_normal' => 'Kredit'],
            ['id' => 72, 'title' => 'Pendapatan Jasa Pinjaman non anggota', 'parent_id' => 71, 'order' => 1, 'kode_coa' => '4201', 'kelompok' => 'Pendapatan Jasa Pinjaman non anggota', 'saldo_normal' => 'Kredit'],
            ['id' => 73, 'title' => 'Pendapatan Administrasi non anggota', 'parent_id' => 71, 'order' => 2, 'kode_coa' => '4202', 'kelompok' => 'Pendapatan Administrasi non anggota', 'saldo_normal' => 'Kredit'],
            ['id' => 74, 'title' => 'Pendapatan Provisi non anggota', 'parent_id' => 71, 'order' => 3, 'kode_coa' => '4203', 'kelompok' => 'Pendapatan Provisi non anggota', 'saldo_normal' => 'Kredit'],
            ['id' => 75, 'title' => 'Pendapatan Jasa Pelayanan Lainnya non anggota', 'parent_id' => 71, 'order' => 4, 'kode_coa' => '4204', 'kelompok' => 'Pendapatan Jasa Pelayanan Lainnya non anggota', 'saldo_normal' => 'Kredit'],

            ['id' => 76, 'title' => 'BEBAN', 'parent_id' => -1, 'order' => 6, 'kode_coa' => '5', 'kelompok' => 'BEBAN', 'saldo_normal' => 'Debet'],
            ['id' => 77, 'title' => 'BEBAN POKOK', 'parent_id' => 76, 'order' => 1, 'kode_coa' => '51', 'kelompok' => 'BEBAN POKOK', 'saldo_normal' => 'Debet'],
            ['id' => 78, 'title' => 'Beban Pokok Anggota', 'parent_id' => 77, 'order' => 1, 'kode_coa' => '5101', 'kelompok' => 'Beban Pokok Anggota', 'saldo_normal' => 'Debet'],
            ['id' => 79, 'title' => 'Beban Jasa Simpanan/Tabungan dari Anggota', 'parent_id' => 78, 'order' => 1, 'kode_coa' => '51011', 'kelompok' => 'Beban Jasa Simpanan/Tabungan dari Anggota', 'saldo_normal' => 'Debet'],
            ['id' => 80, 'title' => 'Beban Jasa Simpanan Berjangka dari Anggota', 'parent_id' => 78, 'order' => 2, 'kode_coa' => '51012', 'kelompok' => 'Beban Jasa Simpanan Berjangka dari Anggota', 'saldo_normal' => 'Debet'],

            ['id' => 81, 'title' => 'Beban Pokok Non Anggota', 'parent_id' => 77, 'order' => 2, 'kode_coa' => '5102', 'kelompok' => 'Beban Pokok Non Anggota', 'saldo_normal' => 'Debet'],
            ['id' => 82, 'title' => 'Beban Jasa Simpanan/Tabungan dari Non Anggota', 'parent_id' => 81, 'order' => 1, 'kode_coa' => '51021', 'kelompok' => 'Beban Jasa Simpanan/Tabungan dari Non Anggota', 'saldo_normal' => 'Debet'],
            ['id' => 83, 'title' => 'Beban Jasa Simpanan Berjangka dari Non Anggota', 'parent_id' => 81, 'order' => 2, 'kode_coa' => '51022', 'kelompok' => 'Beban Jasa Simpanan Berjangka dari Non Anggota', 'saldo_normal' => 'Debet'],
            ['id' => 84, 'title' => 'Beban Jasa Hutang Bank', 'parent_id' => 81, 'order' => 3, 'kode_coa' => '51023', 'kelompok' => 'Beban Jasa Hutang Bank', 'saldo_normal' => 'Debet'],
            ['id' => 85, 'title' => 'Beban Jasa Pinjaman LPDB', 'parent_id' => 81, 'order' => 4, 'kode_coa' => '51024', 'kelompok' => 'Beban Jasa Pinjaman LPDB', 'saldo_normal' => 'Debet'],
            ['id' => 86, 'title' => 'Beban Modal Penyertaan', 'parent_id' => 81, 'order' => 5, 'kode_coa' => '51025', 'kelompok' => 'Beban Modal Penyertaan', 'saldo_normal' => 'Debet'],
            ['id' => 87, 'title' => 'Beban Jasa Pinjaman Pihak ke III', 'parent_id' => 81, 'order' => 6, 'kode_coa' => '51026', 'kelompok' => 'Beban Jasa Pinjaman Pihak ke III', 'saldo_normal' => 'Debet'],

            ['id' => 88, 'title' => 'BEBAN USAHA', 'parent_id' => 76, 'order' => 2, 'kode_coa' => '52', 'kelompok' => 'BEBAN USAHA', 'saldo_normal' => 'Debet'],
            ['id' => 89, 'title' => 'Biaya Penyisihan Penghapusan Piutang', 'parent_id' => 88, 'order' => 1, 'kode_coa' => '5201', 'kelompok' => 'Biaya Penyisihan Penghapusan Piutang', 'saldo_normal' => 'Debet'],
            ['id' => 90, 'title' => 'Biaya bunga pinjaman', 'parent_id' => 88, 'order' => 2, 'kode_coa' => '5202', 'kelompok' => 'Biaya bunga pinjaman', 'saldo_normal' => 'Debet'],
            ['id' => 91, 'title' => 'Honor karyawan', 'parent_id' => 88, 'order' => 3, 'kode_coa' => '5203', 'kelompok' => 'Honor karyawan', 'saldo_normal' => 'Debet'],
            ['id' => 92, 'title' => 'Biaya listrik, air, dan telepon', 'parent_id' => 88, 'order' => 4, 'kode_coa' => '5204', 'kelompok' => 'Biaya listrik, air, dan telepon', 'saldo_normal' => 'Debet'],
            ['id' => 93, 'title' => 'Biaya penyusutan', 'parent_id' => 88, 'order' => 5, 'kode_coa' => '5205', 'kelompok' => 'Biaya penyusutan', 'saldo_normal' => 'Debet'],
            ['id' => 94, 'title' => 'Biaya pemeliharaan', 'parent_id' => 88, 'order' => 6, 'kode_coa' => '5206', 'kelompok' => 'Biaya pemeliharaan', 'saldo_normal' => 'Debet'],
            ['id' => 95, 'title' => 'Biaya Pemasaran dan Promosi', 'parent_id' => 88, 'order' => 7, 'kode_coa' => '5207', 'kelompok' => 'Biaya Pemasaran dan Promosi', 'saldo_normal' => 'Debet'],
            ['id' => 96, 'title' => 'Biaya Transportasi', 'parent_id' => 88, 'order' => 8, 'kode_coa' => '5208', 'kelompok' => 'Biaya Transportasi', 'saldo_normal' => 'Debet'],
            ['id' => 97, 'title' => 'Biaya administrasi dan umum', 'parent_id' => 88, 'order' => 9, 'kode_coa' => '5209', 'kelompok' => 'Biaya administrasi dan umum', 'saldo_normal' => 'Debet'],
            ['id' => 98, 'title' => 'Biaya Pajak (tidak termasuk pajak penghasilan)', 'parent_id' => 88, 'order' => 10, 'kode_coa' => '5214', 'kelompok' => 'Biaya Pajak (tidak termasuk pajak penghasilan)', 'saldo_normal' => 'Debet'],
            ['id' => 99, 'title' => 'Biaya operasional lainnya', 'parent_id' => 88, 'order' => 11, 'kode_coa' => '5215', 'kelompok' => 'Biaya operasional lainnya', 'saldo_normal' => 'Debet'],

            ['id' => 100, 'title' => 'BEBAN PERKOPERASIAN', 'parent_id' => 76, 'order' => 3, 'kode_coa' => '53', 'kelompok' => 'BEBAN PERKOPERASIAN', 'saldo_normal' => 'Debet'],
            ['id' => 101, 'title' => 'Beban Pemawas, dewan, pengurus, koperasi', 'parent_id' => 100, 'order' => 1, 'kode_coa' => '5301', 'kelompok' => 'Beban Pemawas, dewan, pengurus, koperasi', 'saldo_normal' => 'Debet'],
            ['id' => 102, 'title' => 'Beban Pendidikan, Pendidikan dan Pelatihan', 'parent_id' => 100, 'order' => 2, 'kode_coa' => '5302', 'kelompok' => 'Beban Pendidikan, Pendidikan dan Pelatihan', 'saldo_normal' => 'Debet'],
            ['id' => 103, 'title' => 'Beban Rapat Anggota', 'parent_id' => 100, 'order' => 3, 'kode_coa' => '5303', 'kelompok' => 'Beban Rapat Anggota', 'saldo_normal' => 'Debet'],

            ['id' => 104, 'title' => 'PENDAPATAN DAN BEBAN PENDAPATAN LAIN-LAIN', 'parent_id' => -1, 'order' => 7, 'kode_coa' => '6', 'kelompok' => 'PENDAPATAN DAN BEBAN PENDAPATAN LAIN-LAIN', 'saldo_normal' => 'Kredit'],
            ['id' => 105, 'title' => 'Pendapatan Dividen dan Bag Hasil Usaha', 'parent_id' => 104, 'order' => 1, 'kode_coa' => '6101', 'kelompok' => 'Pendapatan Dividen dan Bag Hasil Usaha', 'saldo_normal' => 'Kredit'],
            ['id' => 106, 'title' => 'Pendapatan sewa', 'parent_id' => 104, 'order' => 2, 'kode_coa' => '6102', 'kelompok' => 'Pendapatan sewa', 'saldo_normal' => 'Kredit'],
            ['id' => 107, 'title' => 'Pendapatan lainnya', 'parent_id' => 104, 'order' => 3, 'kode_coa' => '6103', 'kelompok' => 'Pendapatan lainnya', 'saldo_normal' => 'Kredit'],

            ['id' => 108, 'title' => 'BEBAN PENDAPATAN LAIN-LAIN', 'parent_id' => 104, 'order' => 4, 'kode_coa' => '63', 'kelompok' => 'BEBAN PENDAPATAN LAIN-LAIN', 'saldo_normal' => 'Debet'],
            ['id' => 109, 'title' => 'Beban Pajak Penghasilan', 'parent_id' => 108, 'order' => 1, 'kode_coa' => '6301', 'kelompok' => 'Beban Pajak Penghasilan', 'saldo_normal' => 'Debet'],
            ['id' => 110, 'title' => 'Biaya Lain-lain', 'parent_id' => 108, 'order' => 2, 'kode_coa' => '6302', 'kelompok' => 'Biaya Lain-lain', 'saldo_normal' => 'Debet'],
            ['id' => 111, 'title' => 'Jasa Tahu Berakhir', 'parent_id' => 108, 'order' => 3, 'kode_coa' => '6303', 'kelompok' => 'Jasa Tahu Berakhir', 'saldo_normal' => 'Debet'],
        ]);


    }
}
