<?php

namespace App\Livewire\Publik;

use App\Models\AnggotaKoperasi;
use Livewire\Component;

class CekAnggota extends Component
{
    public $flag = false;
    public $no_anggota, $nik;
    public $anggotaId;

    public function prosesNomor(){
        $anggota = AnggotaKoperasi::where([
            'no_anggota' => $this->no_anggota,
            'ktp' => $this->nik,
        ])->first();

        if ($anggota) {
            # code...
            $this->flag = true;
            $this->anggotaId = $anggota->id;
        }else{
            $this->reset(['flag','anggotaId']);
        }
    }

    public function render()
    {
        return view('livewire.publik.cek-anggota');
    }
}
