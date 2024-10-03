<?php

namespace App\Http\Controllers;

use App\Filament\Pages\JurnalUmum;
use App\Models\AnggotaKoperasi;
use App\Models\JurnalUmum as ModelsJurnalUmum;
use App\Models\KonfigurasiCOA;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    static function rupiah($angka){

        $hasil_rupiah = "Rp" . number_format($angka,0,',','.').",-";
        return $hasil_rupiah;

    }

    public function jurnal_umum($konfigurasi_coa_id, $nominal, $anggota_id,$jurnal_kode = null, $deskripsi= null, $tanggal, $hapus = null)
    {
        //menambah data ke jurnal umum
        $kon = KonfigurasiCOA::where('nama', $konfigurasi_coa_id)->get();

        $car = Carbon::now()->isoFormat('YYYYMMDD');

        $date = $tanggal;
        $anggota = AnggotaKoperasi::where('id',$anggota_id)->first();

        $jurnal =  date('YmdHis', strtotime($date)) . '#' . $anggota->identitas_koperasi_id . '#' . auth()->user()->id.'#'.$anggota->id;

        if ($hapus) {
            # code...
            ModelsJurnalUmum::where('jurnal',$jurnal)->delete();
            return true;
        }
        foreach ($kon as $key) {
            $nom = $nominal;
            if ($key->persen) {
                # code...
                $nom = $nominal * ($key->persen / 100);
            }
            ModelsJurnalUmum::updateOrCreate([
                'jurnal' => $jurnal_kode ?? $jurnal,
                'akun' => $key->akun,
            ],[
                'tanggal' => $date,
                'deskripsi' => $konfigurasi_coa_id. ' '.@$deskripsi,
                'akun' => $key->akun,
                'd_k' => $key->d_k,
                'nominal' => $nom,
                'user_id' => auth()->user()->id,
                'jurnal' => $jurnal_kode ?? $jurnal,
                'identitas_koperasi_id' => $anggota->identitas_koperasi_id
            ]);

        }


        return true;
    }
}
