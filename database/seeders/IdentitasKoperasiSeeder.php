<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class IdentitasKoperasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $faker = Faker::create('id_ID'); // Menggunakan locale Indonesia untuk Faker

        $banks = [
            'Bank BRI', 'Bank Mandiri', 'Bank BNI', 'Bank BCA', 'Bank CIMB Niaga',
            'Bank BTN', 'Bank Danamon', 'Bank Permata', 'Bank Sinarmas', 'Bank Mega'
        ];

        for ($i = 0; $i < 20; $i++) {
            DB::table('identitas_koperasis')->insert([
                'nama_koperasi' => $faker->company,
                'no_badan_hukum' => $faker->numerify('##########'),
                'tgl_badan_hukum' => $faker->date(),
                'nomor_pad_terakhir' => $faker->regexify('PAD-2023-00[1-9]'),
                'tgl_pad' => $faker->date(),
                'alamat' => $faker->address,
                'jalan' => $faker->streetAddress,
                'desa_kelurahan' => $faker->citySuffix,
                'kecamatan' => $faker->citySuffix,
                'kabupaten_kota' => $faker->city,
                'provinsi' => $faker->state,
                'nama_pengurus' => $faker->name,
                'nama_pengawas' => $faker->name,
                'telp_fax_email' => $faker->phoneNumber . ' / ' . $faker->phoneNumber . ' / ' . $faker->email,
                'website' => $faker->url,
                'email' => $faker->email,
                'npwp_koperasi' => $faker->numerify('##.###.###.#-###.###'),
                'nomor_rekening_nama_koperasi' => $faker->randomElement($banks) . ' - ' . $faker->bankAccountNumber,
                'bentuk_koperasi' => $faker->randomElement(['Koperasi Simpan Pinjam', 'Koperasi Konsumen', 'Koperasi Produksi', 'Koperasi Pemasaran']),
                'jenis_koperasi' => $faker->randomElement(['Simpan Pinjam', 'Konsumen', 'Produksi', 'Pemasaran']),
                'nomor_induk_koperasi_nik' => $faker->numerify('################'),
                'iusp' => $faker->regexify('IUSP-2023-00[1-9]'),
                'tgl_iusp' => $faker->date(),
                'nib' => $faker->regexify('NIB-2023-00[1-9]'),
                'tgl_nib' => $faker->date(),
                'jumlah_anggota_pria' => $faker->numberBetween(50, 500),
                'jumlah_anggota_wanita' => $faker->numberBetween(50, 500),
                'jumlah_kantor_cabang' => $faker->numberBetween(1, 10),
                'user_id' => 2
            ]);
        }
    }
}
