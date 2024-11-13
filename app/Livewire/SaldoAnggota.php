<?php

namespace App\Livewire;

use App\Models\AnggotaKoperasi;
use App\Models\IdentitasKoperasi;
use App\Models\Kredit;
use App\Models\KreditKonvensional;
use App\Models\SimpananLainnyaAnggota;
use App\Models\SimpananNonModalData;
use App\Models\SimpananPokokAnggota;
use App\Models\SimpananWajibAnggota;
use Livewire\Component;

class SaldoAnggota extends Component
{
    public $identitas_koperasi;
    public $anggota;
    public $menu;

    public function mount(){
        if (auth()->user()->hasRole('Admin Dinkop')) {
            $firstOption = IdentitasKoperasi::get()->pluck('id')->first();
        } else {
            $firstOption = IdentitasKoperasi::where('user_id', auth()->user()->id)
                                            ->pluck('id')
                                            ->first();
        }

        $this->identitas_koperasi = $firstOption;
    }

    public function downloadPDF(){
        $anggota = AnggotaKoperasi::where('identitas_koperasi_id',$this->identitas_koperasi)->get();

        $nama_menu = [];
        foreach ($anggota as $an => $ang) {
            # code...
            $data['simpanan_pokok'] = SimpananPokokAnggota::where('anggota_koperasi_id',$ang->id)->get();
            $data['simpanan_lainnya'] = SimpananLainnyaAnggota::where('anggota_koperasi_id',$ang->id)->get();
            $data['simpanan_wajib'] = SimpananWajibAnggota::where('anggota_koperasi_id',$ang->id)->get();
            $data['kredit'] = Kredit::with('kredit_angsuran')->where('anggota_koperasi_id',$ang->id)->where('kredit','Flat')->get();
            $data['kredit_konvensional'] = KreditKonvensional::with('kredit_konvensional_angsuran')->where('anggota_koperasi_id',$ang->id)->get();
            foreach ($data['kredit'] as $key => $value) {
                # code...
                foreach ($value['kredit_angsuran'] as $key2 => $value2) {
                    # code...
                    // $this->angsuran[$value2['id']] = $value2;
                }
            }
            $data['identitas_koperasi'] = IdentitasKoperasi::where('id',$this->identitas_koperasi)->first();

            // hitung
            $porto = [];



            $total = 0;
            foreach ($data['simpanan_pokok'] as $key => $value) {
                # code...
                if ($value['d_k'] == 'Debet') {
                    $total += $value['nominal'];
                }

                if ($value['d_k'] == 'Kredit') {
                    $total -= $value['nominal'];
                }

            }

            $porto ['Simpanan Pokok'] = $total;

            $total = 0;
            foreach ($data['simpanan_wajib'] as $key => $value) {
                # code...
                if ($value['d_k'] == 'Debet') {
                    $total += $value['nominal'];
                }

                if ($value['d_k'] == 'Kredit') {
                    $total -= $value['nominal'];
                }

            }

            $porto ['Simpanan Wajib'] = $total;

            $total = 0;
            foreach ($data['simpanan_lainnya'] as $key => $value) {
                # code...
                if ($value['d_k'] == 'Debet') {
                    $total += $value['nominal'];
                }

                if ($value['d_k'] == 'Kredit') {
                    $total -= $value['nominal'];
                }

            }

            $porto ['Simpanan Lainnya'] = $total;


            $sim_non = SimpananNonModalData::with('simpanan_non_modal_menu')->where('anggota_koperasi_id',$ang->id)->get()->groupBy('menu_id');

            foreach ($sim_non as $key2 => $value2) {
                # code...
                $total = 0;
                $menu_id = 0;
                foreach ($value2 as $key => $value) {
                    # code...
                    if ($value['d_k'] == 'Debet') {
                        $total += $value['nominal'];
                    }

                    if ($value['d_k'] == 'Kredit') {
                        $total -= $value['nominal'];
                    }

                    $menu_id = $value->menu_id;
                }
                $porto [$value->simpanan_non_modal_menu->nama_menu] = $total;

            }

            $anggota[$an]->porto = $porto;
        }

        // untuk nama menu
        foreach ($anggota as $key => $value) {
            # code...
            foreach ($value->porto as $key2 => $value2) {
                # code...
                $nama_menu [] = $key2;
            }
        }

        session(['saldo-anggota' => $anggota]);
        session(['saldo-anggota-menu' => array_unique($nama_menu)]);

        $_url = '/admin/cetak/saldo-anggota?identitas_koperasi_id='.$this->identitas_koperasi;
            return redirect($_url);
    }

    public function render()
    {
        $anggota = AnggotaKoperasi::where('identitas_koperasi_id',$this->identitas_koperasi)->get();

        $nama_menu = [];
        foreach ($anggota as $an => $ang) {
            # code...
            $data['simpanan_pokok'] = SimpananPokokAnggota::where('anggota_koperasi_id',$ang->id)->get();
            $data['simpanan_lainnya'] = SimpananLainnyaAnggota::where('anggota_koperasi_id',$ang->id)->get();
            $data['simpanan_wajib'] = SimpananWajibAnggota::where('anggota_koperasi_id',$ang->id)->get();
            $data['kredit'] = Kredit::with('kredit_angsuran')->where('anggota_koperasi_id',$ang->id)->where('kredit','Flat')->get();
            $data['kredit_konvensional'] = KreditKonvensional::with('kredit_konvensional_angsuran')->where('anggota_koperasi_id',$ang->id)->get();
            foreach ($data['kredit'] as $key => $value) {
                # code...
                foreach ($value['kredit_angsuran'] as $key2 => $value2) {
                    # code...
                    // $this->angsuran[$value2['id']] = $value2;
                }
            }
            $data['identitas_koperasi'] = IdentitasKoperasi::where('id',$this->identitas_koperasi)->first();

            // hitung
            $porto = [];

            $total = 0;
            foreach ($data['simpanan_pokok'] as $key => $value) {
                # code...
                if ($value['d_k'] == 'Debet') {
                    $total += $value['nominal'];
                }

                if ($value['d_k'] == 'Kredit') {
                    $total -= $value['nominal'];
                }

            }

            $porto ['Simpanan Pokok'] = $total;

            $total = 0;
            foreach ($data['simpanan_wajib'] as $key => $value) {
                # code...
                if ($value['d_k'] == 'Debet') {
                    $total += $value['nominal'];
                }

                if ($value['d_k'] == 'Kredit') {
                    $total -= $value['nominal'];
                }

            }

            $porto ['Simpanan Wajib'] = $total;

            $total = 0;
            foreach ($data['simpanan_lainnya'] as $key => $value) {
                # code...
                if ($value['d_k'] == 'Debet') {
                    $total += $value['nominal'];
                }

                if ($value['d_k'] == 'Kredit') {
                    $total -= $value['nominal'];
                }

            }

            $porto ['Simpanan Lainnya'] = $total;


            $sim_non = SimpananNonModalData::with('simpanan_non_modal_menu')->where('anggota_koperasi_id',$ang->id)->get()->groupBy('menu_id');

            foreach ($sim_non as $key2 => $value2) {
                # code...
                $total = 0;
                $menu_id = 0;
                foreach ($value2 as $key => $value) {
                    # code...
                    if ($value['d_k'] == 'Debet') {
                        $total += $value['nominal'];
                    }

                    if ($value['d_k'] == 'Kredit') {
                        $total -= $value['nominal'];
                    }

                    $menu_id = $value->menu_id;
                }
                $porto [$value->simpanan_non_modal_menu->nama_menu] = $total;
            }

            $anggota[$an]->porto = $porto;
        }

        // untuk nama menu
        foreach ($anggota as $key => $value) {
            # code...
            foreach ($value->porto as $key2 => $value2) {
                # code...
                $nama_menu [] = $key2;
            }
        }
        $data['anggota'] = $anggota;
        $data['menu'] = array_unique($nama_menu);
        $this->anggota = $anggota;
        $this->menu = array_unique($nama_menu);
        return view('livewire.saldo-anggota',$data);
    }
}
