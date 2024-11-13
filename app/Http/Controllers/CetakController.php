<?php

namespace App\Http\Controllers;

use App\Models\AnggotaKoperasi;
use App\Models\IdentitasKoperasi;
use App\Models\JurnalUmum;
use App\Models\MasterCoa;
use Illuminate\Http\Request;

class CetakController extends Controller
{
    //
    public function jurnalUmum(Request $request){
        ini_set('memory_limit', '-1');

        if (@$request->tgl_awal == null || @$request->tgl_awal == null || @$request->identitas_koperasi_id == null) {
            # code...
            dd('hayo ngapain');
        }


        $jurnal = JurnalUmum::with('coa','identitas_koperasi')->whereBetween('tanggal', [$request->tgl_awal,$request->tgl_akhir])
        ->where('identitas_koperasi_id',$request->identitas_koperasi_id)
        ->orderBy('tanggal','ASC')
        ->get()->groupBy('jurnal')->toArray();

        $data['jurnal'] = $jurnal;
        $data['periode'] = $request->tgl_awal.' - '.$request->tgl_akhir;

        return view('cetak.jurnal-umum',$data);
    }


    public function laporanAkun(Request $request){
        ini_set('memory_limit', '-1');

        if (@$request->tgl_awal == null || @$request->tgl_awal == null || @$request->identitas_koperasi_id == null) {
            # code...
            dd('hayo ngapain');
        }


        $identitas = IdentitasKoperasi::where('id',$request->identitas_koperasi_id)->first();

        $coas = MasterCoa::whereRaw('LENGTH(kode_coa) >= 4')->orderBy('kode_coa','ASC')->get();

        // return response()->json([$old,$now,$total]);
        $laporan_akun = $this->shu_all($coas,$request->tgl_awal,$request->tgl_akhir,$request->identitas_koperasi_id);

        $data['query'] = $_SERVER['QUERY_STRING'];

        $data['akuntansi'] = $laporan_akun->toArray();
        $data['identitas'] = $identitas;
        $data['tgl_awal'] = $request->tgl_awal;
        $data['tgl_akhir'] = $request->tgl_akhir;

        return view('cetak.laporan-akun',$data);
    }

    private function shu_all($coas,$tgl_awal,$tgl_akhir,$identitas_koperasi_id){
        // ambil shu saat ini
        $coa_nows = $coas;
        foreach ($coa_nows as $key => $coa_now) {
            # code...
            $jurnal_umum_debet = JurnalUmum::where('akun',$coa_now->kode_coa)->where('d_k','debet')->where('identitas_koperasi_id',$identitas_koperasi_id)->whereBetween('tanggal',[$tgl_awal,$tgl_akhir])->get()->sum('nominal');
            $jurnal_umum_kredit = JurnalUmum::where('akun',$coa_now->kode_coa)->where('d_k','kredit')->where('identitas_koperasi_id',$identitas_koperasi_id)->whereBetween('tanggal',[$tgl_awal,$tgl_akhir])->get()->sum('nominal');

            $nom_coa = 0;
            // if ($riwayat_coa->saldo_normal == 'Debet') {
            //     # code...
            //     $nom_coa = round(@$riwayat_coa->nominal);
            // }else{
            //     $nom_coa = 0 - round(@$riwayat_coa->nominal);

            // }


            $coa_nows[$key]->nominal = abs($nom_coa + round($jurnal_umum_debet - $jurnal_umum_kredit,2));
        }

        return $coa_nows;
    }

    public function laporanAkunCoa(Request $request,$coa){
        ini_set('memory_limit', '-1');

        if (@$request->tgl_awal == null || @$request->tgl_awal == null || @$request->identitas_koperasi_id == null) {
            # code...
            dd('hayo ngapain');
        }




        $identitas = IdentitasKoperasi::where('id',$request->identitas_koperasi_id)->first();

        $jurnal_umum = JurnalUmum::where('akun',$coa)->where('identitas_koperasi_id',$request->identitas_koperasi_id)->orderBy('tanggal','ASC')->get();
        $coa = MasterCoa::whereRaw('LENGTH(kode_coa) >= 4')->where('kode_coa',$coa)->first();
        $total = 0;
        foreach ($jurnal_umum as $key => $ju) {
            # code...
            if ($ju->d_k == 'debet') {
                # code...
                $total += $ju->nominal;
            }else{
                $total -= $ju->nominal;

            }


        }

        $first_data = array('coa' => $coa->toArray(),'jurnal_umum' => $jurnal_umum->toArray(),'total' => $total);

        $data['akuntansi'] = $first_data;

        $data_lama = [];
        $data_baru = [];
        foreach ($first_data['jurnal_umum'] as $key => $value) {
            # code...
            if ($value['tanggal'] <= $request->tgl_akhir && $value['tanggal'] >= $request->tgl_awal) {
                # code...
                $data_baru [] = $value;
            }else if ($value['tanggal'] < $request->tgl_awal){
                $data_lama[] = $value;
            }
        }

        $total = 0;
        foreach ($data_lama as $key => $value) {
            # code...
            if ($value['d_k'] == 'debet') {
                # code...
                $total += $value['nominal'];
            }else{
                $total -= $value['nominal'];

            }
        }

        usort($data_baru, fn($a, $b) => $a['tanggal'] <=> $b['tanggal']);


        foreach ($data_baru as $key => $value) {
            # code...
            $jurnal = explode("#",$value['jurnal']);

            $anggota = AnggotaKoperasi::where('id',$jurnal[4])->first();
            $data_baru[$key]['deskripsi'] = $data_baru[$key]['deskripsi'].' | '.($anggota->nama ?? '');
        }

        $data['identitas'] = $identitas;
        $data['total_lama'] =  $total;
        $data['data_baru'] = $data_baru;

        $data['akun_coa'] = $coa;
        $data['tgl_awal'] = $request->tgl_awal;
        $data['tgl_akhir'] = $request->tgl_akhir;

        return view('cetak.laporan-akun-coa',$data);
    }


    public function laporanLabaRugi(Request $request){
        ini_set('memory_limit', '-1');

        if (@$request->tgl_awal == null || @$request->tgl_awal == null || @$request->identitas_koperasi_id == null) {
            # code...
            dd('hayo ngapain');
        }




        $identitas = IdentitasKoperasi::where('id',$request->identitas_koperasi_id)->first();


        $tanggal_awal = $request->tgl_awal;
        $tanggal_akhir = $request->tgl_akhir;

        $tanggal_awal2 = date('Y',strtotime($request->tgl_awal)).'-01-01';
        $tanggal_akhir2 = $request->tgl_akhir;

        $laporan_shu = [];
        // kode 4

        // ambil dari riwayat coa
        for ($i=4; $i <= 7 ; $i++) {
            # code...
            $coas = MasterCoa::whereRaw('LENGTH(kode_coa) >= 4')->where('kode_coa','like',$i.'%')->get();

            foreach ($coas as $key => $coa) {
                # code...

                $jurnal_umum_debet = JurnalUmum::where('akun',$coa->kode_coa)->where('identitas_koperasi_id',$request->identitas_koperasi_id)->whereBetween('tanggal',[$tanggal_awal2,$tanggal_akhir2])->where('d_k','debet')->get()->sum('nominal');
                $jurnal_umum_kredit = JurnalUmum::where('akun',$coa->kode_coa)->where('identitas_koperasi_id',$request->identitas_koperasi_id)->whereBetween('tanggal',[$tanggal_awal2,$tanggal_akhir2])->where('d_k','kredit')->get()->sum('nominal');

                $nom_coa = 0;

                $laporan_shu [] = [
                    'coa' => $i,
                    'data' => $coa->toArray(),
                    'nominal' => abs($nom_coa + round($jurnal_umum_debet - $jurnal_umum_kredit,2))
                ];
            }

        }

        $laporan_shu_new  = [];
        foreach ($laporan_shu as $key => $value) {
            # code...
            $laporan_shu_new [$value['coa']][] = $value;
        }

        $tot_lap_shu = [];
        $tot_lap_shu[4] = 0;
        $tot_lap_shu[5] = 0;
        $tot_lap_shu[6] = 0;
        $tot_lap_shu[7] = 0;

        foreach ($laporan_shu as $key => $value) {
            # code...
            $tot_lap_shu [$value['coa']] += $value['nominal'];
        }


        $perhitungan_shu = $this->perhitungan_shu($tanggal_awal,$tanggal_akhir,$request->identitas_koperasi_id);

        $first_data = array('laporan_shu' => $laporan_shu_new,'total_laporan_shu' => $tot_lap_shu,'laporan_shu_rentang' => $perhitungan_shu['laporan_shu_new_rentang'],'total_laporan_shu_rentang' => $perhitungan_shu['tot_lap_shu_rentang']);

        $data['akuntansi'] = $first_data;

        $data['identitas'] = $identitas;

        $data['tgl_awal'] = $request->tgl_awal;
        $data['tgl_akhir'] = $request->tgl_akhir;

        // dd($data);
        return view('cetak.laporan-laba-rugi',$data);
    }

    public function perhitungan_shu($tanggal_awal,$tanggal_akhir,$identitas_koperasi_id){
        $laporan_shu_rentang = [];
        // kode 4

        // ambil dari riwayat coa
        for ($i=4; $i <= 7 ; $i++) {
            # code...
            $coas = MasterCoa::whereRaw('LENGTH(kode_coa) >= 4')->where('kode_coa','like',$i.'%')->get();

            foreach ($coas as $key => $coa) {
                # code...

                $jurnal_umum_debet = JurnalUmum::where('akun',$coa->kode_coa)->where('identitas_koperasi_id',$identitas_koperasi_id)->whereBetween('tanggal',[$tanggal_awal,$tanggal_akhir])->where('d_k','debet')->get()->sum('nominal');
                $jurnal_umum_kredit = JurnalUmum::where('akun',$coa->kode_coa)->where('identitas_koperasi_id',$identitas_koperasi_id)->whereBetween('tanggal',[$tanggal_awal,$tanggal_akhir])->where('d_k','kredit')->get()->sum('nominal');

                $nom_coa = 0;
                // if ($riwayat_coa->saldo_normal == 'Debet') {
                //     # code...
                //     $nom_coa = round(@$riwayat_coa->nominal);
                // }else{
                //     $nom_coa = 0 - round(@$riwayat_coa->nominal);

                // }


                $laporan_shu_rentang [] = [
                    'coa' => $i,
                    'data' => $coa->toArray(),
                    'nominal' => abs($nom_coa + round($jurnal_umum_debet - $jurnal_umum_kredit,2))
                ];
            }

        }

        $laporan_shu_new_rentang  = [];
        foreach ($laporan_shu_rentang as $key => $value) {
            # code...
            $laporan_shu_new_rentang [$value['coa']][] = $value;
        }

        $tot_lap_shu_rentang = [];
        $tot_lap_shu_rentang[4] = 0;
        $tot_lap_shu_rentang[5] = 0;
        $tot_lap_shu_rentang[6] = 0;
        $tot_lap_shu_rentang[7] = 0;

        foreach ($laporan_shu_rentang as $key => $value) {
            # code...
            $tot_lap_shu_rentang [$value['coa']] += $value['nominal'];
        }

        return [
            'laporan_shu_new_rentang' => $laporan_shu_new_rentang,
            'tot_lap_shu_rentang' => $tot_lap_shu_rentang
        ];
    }

    public function laporanPerubahanModal(Request $request){
        ini_set('memory_limit', '-1');

        if (@$request->tgl_awal == null || @$request->tgl_awal == null || @$request->identitas_koperasi_id == null) {
            # code...
            dd('hayo ngapain');
        }




        $identitas = IdentitasKoperasi::where('id',$request->identitas_koperasi_id)->first();


        $tanggal_awal = $request->tgl_awal;
        $tanggal_akhir = $request->tgl_akhir;

        $tanggal_awal2 = date('Y',strtotime($request->tgl_awal)).'-01-01';
        $tanggal_akhir2 = date('Y-m-d',strtotime($tanggal_awal . "-1 days"));



        $perhitungan_new = $this->perhitungan_perubahan_modal($tanggal_awal,$tanggal_akhir,$request->identitas_koperasi_id);
        $perhitungan_lama = $this->perhitungan_perubahan_modal($tanggal_awal2,$tanggal_akhir2,$request->identitas_koperasi_id);

        $first_data = array('perhitungan_new' => $perhitungan_new,'perhitungan_lama' => $perhitungan_lama);

        $data['akuntansi'] = $first_data;

        $data['identitas'] = $identitas;

        $data['tgl_awal'] = $request->tgl_awal;
        $data['tgl_akhir'] = $request->tgl_akhir;

        return view('cetak.laporan-perubahan-modal',$data);
    }

    public function perhitungan_perubahan_modal($tanggal_awal,$tanggal_akhir,$identitas_koperasi_id){
        $laporan_shu_rentang = [];
        // kode 4

        $laporan_shu = [];
        // ambil dari riwayat coa
        for ($i=3; $i <= 3 ; $i++) {
            # code...
            $coas = MasterCoa::where('kode_coa','like',$i.'%')->get();

            foreach ($coas as $key => $coa) {
                # code...

                $jurnal_umum_debet = JurnalUmum::where('akun',$coa->kode_coa)->where('identitas_koperasi_id',$identitas_koperasi_id)->whereBetween('tanggal',[$tanggal_awal,$tanggal_akhir])->where('d_k','debet')->get()->sum('nominal');

                $nom_coa = 0;
                // if ($riwayat_coa->saldo_normal == 'Debet') {
                //     # code...
                //     $nom_coa = round(@$riwayat_coa->nominal);
                // }else{
                //     $nom_coa = 0 - round(@$riwayat_coa->nominal);

                // }


                if (abs($nom_coa + round($jurnal_umum_debet ,2)) != 0) {
                    # code...
                    $laporan_shu [] = [
                        'coa' => $i,
                        'jenis' => 'kredit',
                        'data' => $coa->toArray(),
                        'nominal' => abs($nom_coa + round($jurnal_umum_debet ,2))
                    ];
                }

            }

        }

        for ($i=3; $i <= 3 ; $i++) {
            # code...
            $coas = MasterCoa::where('kode_coa','like',$i.'%')->get();

            foreach ($coas as $key => $coa) {
                # code...

                $jurnal_umum_kredit = JurnalUmum::where('akun',$coa->kode_coa)->where('identitas_koperasi_id',$identitas_koperasi_id)->whereBetween('tanggal',[$tanggal_awal,$tanggal_akhir])->where('d_k','kredit')->get()->sum('nominal');

                $nom_coa = 0;
                // if ($riwayat_coa->saldo_normal == 'kredit') {
                //     # code...
                //     $nom_coa = round(@$riwayat_coa->nominal);
                // }else{
                //     $nom_coa = 0 - round(@$riwayat_coa->nominal);

                // }

                if (abs($nom_coa + round($jurnal_umum_kredit ,2)) != 0) {
                    # code...
                    $laporan_shu [] = [
                        'coa' => $i,
                        'jenis' => 'debet',
                        'data' => $coa->toArray(),
                        'nominal' => abs($nom_coa + round($jurnal_umum_kredit ,2))
                    ];
                }

            }

        }

        $laporan_shu_group = [];
        $total_debet = 0;
        $total_kredit = 0;

        foreach ($laporan_shu as $item) {
            $laporan_shu_group[$item['jenis']][] = $item;

            // Hitung total debet dan kredit
            if ($item['jenis'] == 'debet') {
                $total_debet += $item['nominal'];
            } elseif ($item['jenis'] == 'kredit') {
                $total_kredit += $item['nominal'];
            }
        }

        return [
            'laporan_shu_group_new' => $laporan_shu_group,
            'total_debet_new' => $total_debet,
            'total_kredit_new' => $total_kredit,
            'total' => $total_debet - $total_kredit,
        ];
    }

    public function laporanPosisiKeuangan(Request $request){
        ini_set('memory_limit', '-1');

        if (@$request->tgl_awal == null || @$request->tgl_awal == null || @$request->identitas_koperasi_id == null) {
            # code...
            dd('hayo ngapain');
        }




        $identitas = IdentitasKoperasi::where('id',$request->identitas_koperasi_id)->first();


        $tanggal_awal = $request->tgl_awal;
        $tanggal_akhir = $request->tgl_akhir;

        $tanggal_awal2 = date('Y',strtotime($request->tgl_awal)).'-01-01';
        $tanggal_akhir2 = $request->tgl_akhir;

        $laporan_shu = [];
        // kode 4

        // ambil dari riwayat coa
        // aktiva
        $coa_aktivas = MasterCoa::with('children')->where('kode_coa','1')->first();

        foreach ($coa_aktivas->children as $key => $value) {
            # code...
            foreach ($value->children as $key2 => $coa) {
                # code...
                $jurnal_umum_debet = JurnalUmum::where('akun',$coa->kode_coa)->where('identitas_koperasi_id',$request->identitas_koperasi_id)->whereBetween('tanggal',[$tanggal_awal2,$tanggal_akhir2])->where('d_k','debet')->get()->sum('nominal');
                $jurnal_umum_kredit = JurnalUmum::where('akun',$coa->kode_coa)->where('identitas_koperasi_id',$request->identitas_koperasi_id)->whereBetween('tanggal',[$tanggal_awal2,$tanggal_akhir2])->where('d_k','kredit')->get()->sum('nominal');

                $nom_coa = 0;

                $laporan_shu [] = [
                    'coa' => str_replace(" ",'_',strtolower($value->title)),
                    'data' => $coa->toArray(),
                    'nominal' => abs($nom_coa + round($jurnal_umum_debet - $jurnal_umum_kredit,2))
                ];
            }
        }

        // hutang lancar
            # code...
        $coa_aktivas = MasterCoa::with('children')->where('kode_coa','like','21%')->get();

        foreach ($coa_aktivas as $key2 => $coa) {
            # code...
            $jurnal_umum_debet = JurnalUmum::where('akun',$coa->kode_coa)->where('identitas_koperasi_id',$request->identitas_koperasi_id)->whereBetween('tanggal',[$tanggal_awal2,$tanggal_akhir2])->where('d_k','debet')->get()->sum('nominal');
            $jurnal_umum_kredit = JurnalUmum::where('akun',$coa->kode_coa)->where('identitas_koperasi_id',$request->identitas_koperasi_id)->whereBetween('tanggal',[$tanggal_awal2,$tanggal_akhir2])->where('d_k','kredit')->get()->sum('nominal');

            $nom_coa = 0;

            $laporan_shu [] = [
                'coa' => 'hutang_lancar',
                'data' => $coa->toArray(),
                'nominal' => abs($nom_coa + round($jurnal_umum_debet - $jurnal_umum_kredit,2))
            ];
        }

        $coa_aktivas = MasterCoa::with('children')->where('kode_coa','like','22%')->get();

        foreach ($coa_aktivas as $key2 => $coa) {
            # code...
            $jurnal_umum_debet = JurnalUmum::where('akun',$coa->kode_coa)->where('identitas_koperasi_id',$request->identitas_koperasi_id)->whereBetween('tanggal',[$tanggal_awal2,$tanggal_akhir2])->where('d_k','debet')->get()->sum('nominal');
            $jurnal_umum_kredit = JurnalUmum::where('akun',$coa->kode_coa)->where('identitas_koperasi_id',$request->identitas_koperasi_id)->whereBetween('tanggal',[$tanggal_awal2,$tanggal_akhir2])->where('d_k','kredit')->get()->sum('nominal');

            $nom_coa = 0;

            $laporan_shu [] = [
                'coa' => 'hutang_jangka_panjang',
                'data' => $coa->toArray(),
                'nominal' => abs($nom_coa + round($jurnal_umum_debet - $jurnal_umum_kredit,2))
            ];
        }

        //modal
        $coa_aktivas = MasterCoa::with('children')->where('kode_coa','like','3%')->get();

        foreach ($coa_aktivas as $key2 => $coa) {
            # code...
            $jurnal_umum_debet = JurnalUmum::where('akun',$coa->kode_coa)->where('identitas_koperasi_id',$request->identitas_koperasi_id)->whereBetween('tanggal',[$tanggal_awal2,$tanggal_akhir2])->where('d_k','debet')->get()->sum('nominal');
            $jurnal_umum_kredit = JurnalUmum::where('akun',$coa->kode_coa)->where('identitas_koperasi_id',$request->identitas_koperasi_id)->whereBetween('tanggal',[$tanggal_awal2,$tanggal_akhir2])->where('d_k','kredit')->get()->sum('nominal');

            $nom_coa = 0;

            $laporan_shu [] = [
                'coa' => 'modal',
                'data' => $coa->toArray(),
                'nominal' => abs($nom_coa + round($jurnal_umum_debet - $jurnal_umum_kredit,2))
            ];
        }

        // shu tahun lalu
        $tgl_awal2 = $tanggal_awal2;
        $tgl_akhir2 = (date('Y',strtotime($tanggal_akhir2)) - 1).'-12-31';
        $perhit = $this->perhitungan_shu($tgl_awal2,$tgl_akhir2,$request->identitas_koperasi_id);

        $perhit = array_values($perhit['tot_lap_shu_rentang']);
        $tot_lap_shu_ren = $perhit[0] - $perhit[1];

        $laporan_shu [] = [
            'coa' => 'shu',
            'data' => $perhit,
            'nominal' => $tot_lap_shu_ren
        ];

        // shu saat ini
        $tgl_awal2 = (date('Y',strtotime($tanggal_akhir2))).'-01-01';
        $tgl_akhir2 = $tanggal_akhir2;
        $perhit = $this->perhitungan_shu($tgl_awal2,$tgl_akhir2,$request->identitas_koperasi_id);

        $perhit = array_values($perhit['tot_lap_shu_rentang']);
        $tot_lap_shu_ren = $perhit[0] - $perhit[1];

        $laporan_shu [] = [
            'coa' => 'shu',
            'data' => $perhit,
            'nominal' => $tot_lap_shu_ren
        ];

        $laporan_shu_new  = [];
        foreach ($laporan_shu as $key => $value) {
            # code...
            $laporan_shu_new [$value['coa']][] = $value;
        }

        $tot_lap_shu = [];
        $tot_lap_shu['aset_lancar'] = 0;
        $tot_lap_shu['aset_tidak_lancar'] = 0;
        $tot_lap_shu['aset_tetap'] = 0;
        $tot_lap_shu['aset_lainnya'] = 0;
        $tot_lap_shu['hutang_lancar'] = 0;
        $tot_lap_shu['hutang_jangka_panjang'] = 0;
        $tot_lap_shu['modal'] = 0;
        $tot_lap_shu['shu'] = 0;

        foreach ($laporan_shu as $key => $value) {
            # code...
            $tot_lap_shu [$value['coa']] += $value['nominal'];
        }

        // $final

        $final_total = [];
        $final_total['aset'] = $tot_lap_shu['aset_lancar'] + $tot_lap_shu['aset_tidak_lancar'] + $tot_lap_shu['aset_tetap'] + $tot_lap_shu['aset_lainnya'];
        $final_total['hutang_dan_modal'] = $tot_lap_shu['hutang_lancar'] + $tot_lap_shu['hutang_jangka_panjang'] + $tot_lap_shu['modal'] + $tot_lap_shu['shu'] ;
        // $data['meta'] = array('status' => true, 'message' => 'Success');
        $data['data'] = array('final_total' => $final_total,'laporan_shu' => $laporan_shu_new,'total_laporan_shu' => $tot_lap_shu);
        $data['akuntansi'] = $data['data'];

        $data['identitas'] = $identitas;

        $data['tgl_awal'] = $request->tgl_awal;
        $data['tgl_akhir'] = $request->tgl_akhir;

        // dd($data);
        return view('cetak.laporan-posisi-keuangan',$data);
    }

    public function laporanCalk(Request $request){
        ini_set('memory_limit', '-1');

        if (@$request->tgl_awal == null || @$request->tgl_awal == null || @$request->identitas_koperasi_id == null) {
            # code...
            dd('hayo ngapain');
        }




        $identitas = IdentitasKoperasi::where('id',$request->identitas_koperasi_id)->first();


        $tanggal_awal = $request->tgl_awal;
        $tanggal_akhir = $request->tgl_akhir;

        $tanggal_awal2 = date('Y',strtotime($request->tgl_awal)).'-01-01';
        $tanggal_akhir2 = $request->tgl_akhir;

        $laporan_shu = [];
        // kode 4

        // ambil dari riwayat coa
        // aktiva
        $coa_aktivas = MasterCoa::with('children')->where('kode_coa','1')->first();

        foreach ($coa_aktivas->children as $key => $value) {
            # code...
            foreach ($value->children as $key2 => $coa) {
                # code...
                $jurnal_umum_debet = JurnalUmum::where('akun',$coa->kode_coa)->where('identitas_koperasi_id',$request->identitas_koperasi_id)->whereBetween('tanggal',[$tanggal_awal2,$tanggal_akhir2])->where('d_k','debet')->get()->sum('nominal');
                $jurnal_umum_kredit = JurnalUmum::where('akun',$coa->kode_coa)->where('identitas_koperasi_id',$request->identitas_koperasi_id)->whereBetween('tanggal',[$tanggal_awal2,$tanggal_akhir2])->where('d_k','kredit')->get()->sum('nominal');

                $nom_coa = 0;

                $laporan_shu [] = [
                    'coa' => str_replace(" ",'_',strtolower($value->title)),
                    'data' => $coa->toArray(),
                    'nominal' => abs($nom_coa + round($jurnal_umum_debet - $jurnal_umum_kredit,2))
                ];
            }
        }

        // hutang lancar
            # code...
        $coa_aktivas = MasterCoa::with('children')->where('kode_coa','like','21%')->get();

        foreach ($coa_aktivas as $key2 => $coa) {
            # code...
            $jurnal_umum_debet = JurnalUmum::where('akun',$coa->kode_coa)->where('identitas_koperasi_id',$request->identitas_koperasi_id)->whereBetween('tanggal',[$tanggal_awal2,$tanggal_akhir2])->where('d_k','debet')->get()->sum('nominal');
            $jurnal_umum_kredit = JurnalUmum::where('akun',$coa->kode_coa)->where('identitas_koperasi_id',$request->identitas_koperasi_id)->whereBetween('tanggal',[$tanggal_awal2,$tanggal_akhir2])->where('d_k','kredit')->get()->sum('nominal');

            $nom_coa = 0;

            $laporan_shu [] = [
                'coa' => 'hutang_lancar',
                'data' => $coa->toArray(),
                'nominal' => abs($nom_coa + round($jurnal_umum_debet - $jurnal_umum_kredit,2))
            ];
        }

        $coa_aktivas = MasterCoa::with('children')->where('kode_coa','like','22%')->get();

        foreach ($coa_aktivas as $key2 => $coa) {
            # code...
            $jurnal_umum_debet = JurnalUmum::where('akun',$coa->kode_coa)->where('identitas_koperasi_id',$request->identitas_koperasi_id)->whereBetween('tanggal',[$tanggal_awal2,$tanggal_akhir2])->where('d_k','debet')->get()->sum('nominal');
            $jurnal_umum_kredit = JurnalUmum::where('akun',$coa->kode_coa)->where('identitas_koperasi_id',$request->identitas_koperasi_id)->whereBetween('tanggal',[$tanggal_awal2,$tanggal_akhir2])->where('d_k','kredit')->get()->sum('nominal');

            $nom_coa = 0;

            $laporan_shu [] = [
                'coa' => 'hutang_jangka_panjang',
                'data' => $coa->toArray(),
                'nominal' => abs($nom_coa + round($jurnal_umum_debet - $jurnal_umum_kredit,2))
            ];
        }

        //modal
        $coa_aktivas = MasterCoa::with('children')->where('kode_coa','like','3%')->get();

        foreach ($coa_aktivas as $key2 => $coa) {
            # code...
            $jurnal_umum_debet = JurnalUmum::where('akun',$coa->kode_coa)->where('identitas_koperasi_id',$request->identitas_koperasi_id)->whereBetween('tanggal',[$tanggal_awal2,$tanggal_akhir2])->where('d_k','debet')->get()->sum('nominal');
            $jurnal_umum_kredit = JurnalUmum::where('akun',$coa->kode_coa)->where('identitas_koperasi_id',$request->identitas_koperasi_id)->whereBetween('tanggal',[$tanggal_awal2,$tanggal_akhir2])->where('d_k','kredit')->get()->sum('nominal');

            $nom_coa = 0;

            $laporan_shu [] = [
                'coa' => 'modal',
                'data' => $coa->toArray(),
                'nominal' => abs($nom_coa + round($jurnal_umum_debet - $jurnal_umum_kredit,2))
            ];
        }

        // shu tahun lalu
        $tgl_awal2 = $tanggal_awal2;
        $tgl_akhir2 = (date('Y',strtotime($tanggal_akhir2)) - 1).'-12-31';
        $perhit = $this->perhitungan_shu($tgl_awal2,$tgl_akhir2,$request->identitas_koperasi_id);

        $perhit = array_values($perhit['tot_lap_shu_rentang']);
        $tot_lap_shu_ren = $perhit[0] - $perhit[1];

        $laporan_shu [] = [
            'coa' => 'shu',
            'data' => $perhit,
            'nominal' => $tot_lap_shu_ren
        ];

        // shu saat ini
        $tgl_awal2 = (date('Y',strtotime($tanggal_akhir2))).'-01-01';
        $tgl_akhir2 = $tanggal_akhir2;
        $perhit = $this->perhitungan_shu($tgl_awal2,$tgl_akhir2,$request->identitas_koperasi_id);

        $perhit = array_values($perhit['tot_lap_shu_rentang']);
        $tot_lap_shu_ren = $perhit[0] - $perhit[1];

        $laporan_shu [] = [
            'coa' => 'shu',
            'data' => $perhit,
            'nominal' => $tot_lap_shu_ren
        ];

        $laporan_shu_new  = [];
        foreach ($laporan_shu as $key => $value) {
            # code...
            $laporan_shu_new [$value['coa']][] = $value;
        }

        $tot_lap_shu = [];
        $tot_lap_shu['aset_lancar'] = 0;
        $tot_lap_shu['aset_tidak_lancar'] = 0;
        $tot_lap_shu['aset_tetap'] = 0;
        $tot_lap_shu['aset_lainnya'] = 0;
        $tot_lap_shu['hutang_lancar'] = 0;
        $tot_lap_shu['hutang_jangka_panjang'] = 0;
        $tot_lap_shu['modal'] = 0;
        $tot_lap_shu['shu'] = 0;

        foreach ($laporan_shu as $key => $value) {
            # code...
            $tot_lap_shu [$value['coa']] += $value['nominal'];
        }

        // $final

        $final_total = [];
        $final_total['aset'] = $tot_lap_shu['aset_lancar'] + $tot_lap_shu['aset_tidak_lancar'] + $tot_lap_shu['aset_tetap'] + $tot_lap_shu['aset_lainnya'];
        $final_total['hutang_dan_modal'] = $tot_lap_shu['hutang_lancar'] + $tot_lap_shu['hutang_jangka_panjang'] + $tot_lap_shu['modal'] + $tot_lap_shu['shu'] ;
        // $data['meta'] = array('status' => true, 'message' => 'Success');
        $data['data'] = array('final_total' => $final_total,'laporan_shu' => $laporan_shu_new,'total_laporan_shu' => $tot_lap_shu);
        $data['akuntansi'] = $data['data'];

        $data['identitas'] = $identitas;
        $data['calk'] = session()->get('calk');

        $data['tgl_awal'] = $request->tgl_awal;
        $data['tgl_akhir'] = $request->tgl_akhir;

        return view('cetak.laporan-calk',$data);
    }

    public function saldoAnggota(Request $request){
        ini_set('memory_limit', '-1');



        $identitas = IdentitasKoperasi::where('id',$request->identitas_koperasi_id)->first();

        $data['identitas'] = $identitas;
        $data['anggota'] = session('saldo-anggota');
        $data['menu'] = session('saldo-anggota-menu');


        return view('cetak.saldo-anggota',$data);
    }

    public function piutangAnggota(Request $request){
        ini_set('memory_limit', '-1');



        $identitas = IdentitasKoperasi::where('id',$request->identitas_koperasi_id)->first();

        $data['identitas'] = $identitas;
        $data['anggota'] = session('piutang-anggota');


        // dd($data);
        return view('cetak.piutang-anggota',$data);
    }


    public function laporanArusKas(Request $request){
        ini_set('memory_limit', '-1');

        if (@$request->tgl_awal == null || @$request->tgl_awal == null || @$request->identitas_koperasi_id == null) {
            # code...
            dd('hayo ngapain');
        }




        $identitas = IdentitasKoperasi::where('id',$request->identitas_koperasi_id)->first();


        $tanggal_awal = $request->tgl_awal;
        $tanggal_akhir = $request->tgl_akhir;

        $tanggal_awal2 = date('Y',strtotime($request->tgl_awal)).'-01-01';
        $tanggal_akhir2 = $request->tgl_akhir;

        $laporan_shu = [];
        // kode 4

        // ambil dari riwayat coa
        // aktiva
        $coa_aktivas = MasterCoa::with('children')->where('kode_coa','1')->first();

        foreach ($coa_aktivas->children as $key => $value) {
            # code...
            foreach ($value->children as $key2 => $coa) {
                # code...
                $jurnal_umum_debet = JurnalUmum::where('akun',$coa->kode_coa)->where('identitas_koperasi_id',$request->identitas_koperasi_id)->whereBetween('tanggal',[$tanggal_awal2,$tanggal_akhir2])->where('d_k','debet')->get()->sum('nominal');
                $jurnal_umum_kredit = JurnalUmum::where('akun',$coa->kode_coa)->where('identitas_koperasi_id',$request->identitas_koperasi_id)->whereBetween('tanggal',[$tanggal_awal2,$tanggal_akhir2])->where('d_k','kredit')->get()->sum('nominal');

                $nom_coa = 0;

                $laporan_shu [] = [
                    'coa' => str_replace(" ",'_',strtolower($value->title)),
                    'data' => $coa->toArray(),
                    'nominal' => abs($nom_coa + round($jurnal_umum_debet - $jurnal_umum_kredit,2))
                ];
            }
        }

        // hutang lancar
            # code...
        $coa_aktivas = MasterCoa::with('children')->where('kode_coa','like','21%')->get();

        foreach ($coa_aktivas as $key2 => $coa) {
            # code...
            $jurnal_umum_debet = JurnalUmum::where('akun',$coa->kode_coa)->where('identitas_koperasi_id',$request->identitas_koperasi_id)->whereBetween('tanggal',[$tanggal_awal2,$tanggal_akhir2])->where('d_k','debet')->get()->sum('nominal');
            $jurnal_umum_kredit = JurnalUmum::where('akun',$coa->kode_coa)->where('identitas_koperasi_id',$request->identitas_koperasi_id)->whereBetween('tanggal',[$tanggal_awal2,$tanggal_akhir2])->where('d_k','kredit')->get()->sum('nominal');

            $nom_coa = 0;

            $laporan_shu [] = [
                'coa' => 'hutang_lancar',
                'data' => $coa->toArray(),
                'nominal' => abs($nom_coa + round($jurnal_umum_debet - $jurnal_umum_kredit,2))
            ];
        }

        $coa_aktivas = MasterCoa::with('children')->where('kode_coa','like','22%')->get();

        foreach ($coa_aktivas as $key2 => $coa) {
            # code...
            $jurnal_umum_debet = JurnalUmum::where('akun',$coa->kode_coa)->where('identitas_koperasi_id',$request->identitas_koperasi_id)->whereBetween('tanggal',[$tanggal_awal2,$tanggal_akhir2])->where('d_k','debet')->get()->sum('nominal');
            $jurnal_umum_kredit = JurnalUmum::where('akun',$coa->kode_coa)->where('identitas_koperasi_id',$request->identitas_koperasi_id)->whereBetween('tanggal',[$tanggal_awal2,$tanggal_akhir2])->where('d_k','kredit')->get()->sum('nominal');

            $nom_coa = 0;

            $laporan_shu [] = [
                'coa' => 'hutang_jangka_panjang',
                'data' => $coa->toArray(),
                'nominal' => abs($nom_coa + round($jurnal_umum_debet - $jurnal_umum_kredit,2))
            ];
        }

        //modal
        $coa_aktivas = MasterCoa::with('children')->where('kode_coa','like','3%')->get();

        foreach ($coa_aktivas as $key2 => $coa) {
            # code...
            $jurnal_umum_debet = JurnalUmum::where('akun',$coa->kode_coa)->where('identitas_koperasi_id',$request->identitas_koperasi_id)->whereBetween('tanggal',[$tanggal_awal2,$tanggal_akhir2])->where('d_k','debet')->get()->sum('nominal');
            $jurnal_umum_kredit = JurnalUmum::where('akun',$coa->kode_coa)->where('identitas_koperasi_id',$request->identitas_koperasi_id)->whereBetween('tanggal',[$tanggal_awal2,$tanggal_akhir2])->where('d_k','kredit')->get()->sum('nominal');

            $nom_coa = 0;

            $laporan_shu [] = [
                'coa' => 'modal',
                'data' => $coa->toArray(),
                'nominal' => abs($nom_coa + round($jurnal_umum_debet - $jurnal_umum_kredit,2))
            ];
        }

        // shu tahun lalu
        $tgl_awal2 = $tanggal_awal2;
        $tgl_akhir2 = (date('Y',strtotime($tanggal_akhir2)) - 1).'-12-31';
        $perhit = $this->perhitungan_shu($tgl_awal2,$tgl_akhir2,$request->identitas_koperasi_id);

        $perhit = array_values($perhit['tot_lap_shu_rentang']);
        $tot_lap_shu_ren = $perhit[0] - $perhit[1];

        $laporan_shu [] = [
            'coa' => 'shu',
            'data' => $perhit,
            'nominal' => $tot_lap_shu_ren
        ];

        // shu saat ini
        $tgl_awal2 = (date('Y',strtotime($tanggal_akhir2))).'-01-01';
        $tgl_akhir2 = $tanggal_akhir2;
        $perhit = $this->perhitungan_shu($tgl_awal2,$tgl_akhir2,$request->identitas_koperasi_id);

        $perhit = array_values($perhit['tot_lap_shu_rentang']);
        $tot_lap_shu_ren = $perhit[0] - $perhit[1];

        $laporan_shu [] = [
            'coa' => 'shu',
            'data' => $perhit,
            'nominal' => $tot_lap_shu_ren
        ];

        $laporan_shu_new  = [];
        foreach ($laporan_shu as $key => $value) {
            # code...
            $laporan_shu_new [$value['coa']][] = $value;
        }

        $tot_lap_shu = [];
        $tot_lap_shu['aset_lancar'] = 0;
        $tot_lap_shu['aset_tidak_lancar'] = 0;
        $tot_lap_shu['aset_tetap'] = 0;
        $tot_lap_shu['aset_lainnya'] = 0;
        $tot_lap_shu['hutang_lancar'] = 0;
        $tot_lap_shu['hutang_jangka_panjang'] = 0;
        $tot_lap_shu['modal'] = 0;
        $tot_lap_shu['shu'] = 0;

        foreach ($laporan_shu as $key => $value) {
            # code...
            $tot_lap_shu [$value['coa']] += $value['nominal'];
        }

        // $final

        $final_total = [];
        $final_total['aset'] = $tot_lap_shu['aset_lancar'] + $tot_lap_shu['aset_tidak_lancar'] + $tot_lap_shu['aset_tetap'] + $tot_lap_shu['aset_lainnya'];
        $final_total['hutang_dan_modal'] = $tot_lap_shu['hutang_lancar'] + $tot_lap_shu['hutang_jangka_panjang'] + $tot_lap_shu['modal'] + $tot_lap_shu['shu'] ;
        // $data['meta'] = array('status' => true, 'message' => 'Success');
        $data['data'] = array('final_total' => $final_total,'laporan_shu' => $laporan_shu_new,'total_laporan_shu' => $tot_lap_shu);
        $data['akuntansi'] = $data['data'];

        $data['identitas'] = $identitas;

        $data['tgl_awal'] = $request->tgl_awal;
        $data['tgl_akhir'] = $request->tgl_akhir;

        // dd($data);
        return view('cetak.laporan-posisi-keuangan',$data);
    }


    public function laporanALK(Request $request){
        ini_set('memory_limit', '-1');

        if (@$request->tgl_awal == null || @$request->tgl_awal == null || @$request->identitas_koperasi_id == null) {
            # code...
            dd('hayo ngapain');
        }




        $identitas = IdentitasKoperasi::where('id',$request->identitas_koperasi_id)->first();


        $tanggal_awal = $request->tgl_awal;
        $tanggal_akhir = $request->tgl_akhir;

        $tanggal_awal2 = date('Y',strtotime($request->tgl_awal)).'-01-01';
        $tanggal_akhir2 = $request->tgl_akhir;

        $laporan_shu = [];
        // kode 4

        // ambil dari riwayat coa
        // aktiva
        $coa_aktivas = MasterCoa::with('children')->where('kode_coa','1')->first();

        foreach ($coa_aktivas->children as $key => $value) {
            # code...
            foreach ($value->children as $key2 => $coa) {
                # code...
                $jurnal_umum_debet = JurnalUmum::where('akun',$coa->kode_coa)->where('identitas_koperasi_id',$request->identitas_koperasi_id)->whereBetween('tanggal',[$tanggal_awal2,$tanggal_akhir2])->where('d_k','debet')->get()->sum('nominal');
                $jurnal_umum_kredit = JurnalUmum::where('akun',$coa->kode_coa)->where('identitas_koperasi_id',$request->identitas_koperasi_id)->whereBetween('tanggal',[$tanggal_awal2,$tanggal_akhir2])->where('d_k','kredit')->get()->sum('nominal');

                $nom_coa = 0;

                $laporan_shu [] = [
                    'coa' => str_replace(" ",'_',strtolower($value->title)),
                    'data' => $coa->toArray(),
                    'nominal' => abs($nom_coa + round($jurnal_umum_debet - $jurnal_umum_kredit,2))
                ];
            }
        }

        // hutang lancar
            # code...
        $coa_aktivas = MasterCoa::with('children')->where('kode_coa','like','21%')->get();

        foreach ($coa_aktivas as $key2 => $coa) {
            # code...
            $jurnal_umum_debet = JurnalUmum::where('akun',$coa->kode_coa)->where('identitas_koperasi_id',$request->identitas_koperasi_id)->whereBetween('tanggal',[$tanggal_awal2,$tanggal_akhir2])->where('d_k','debet')->get()->sum('nominal');
            $jurnal_umum_kredit = JurnalUmum::where('akun',$coa->kode_coa)->where('identitas_koperasi_id',$request->identitas_koperasi_id)->whereBetween('tanggal',[$tanggal_awal2,$tanggal_akhir2])->where('d_k','kredit')->get()->sum('nominal');

            $nom_coa = 0;

            $laporan_shu [] = [
                'coa' => 'hutang_lancar',
                'data' => $coa->toArray(),
                'nominal' => abs($nom_coa + round($jurnal_umum_debet - $jurnal_umum_kredit,2))
            ];
        }

        $coa_aktivas = MasterCoa::with('children')->where('kode_coa','like','22%')->get();

        foreach ($coa_aktivas as $key2 => $coa) {
            # code...
            $jurnal_umum_debet = JurnalUmum::where('akun',$coa->kode_coa)->where('identitas_koperasi_id',$request->identitas_koperasi_id)->whereBetween('tanggal',[$tanggal_awal2,$tanggal_akhir2])->where('d_k','debet')->get()->sum('nominal');
            $jurnal_umum_kredit = JurnalUmum::where('akun',$coa->kode_coa)->where('identitas_koperasi_id',$request->identitas_koperasi_id)->whereBetween('tanggal',[$tanggal_awal2,$tanggal_akhir2])->where('d_k','kredit')->get()->sum('nominal');

            $nom_coa = 0;

            $laporan_shu [] = [
                'coa' => 'hutang_jangka_panjang',
                'data' => $coa->toArray(),
                'nominal' => abs($nom_coa + round($jurnal_umum_debet - $jurnal_umum_kredit,2))
            ];
        }

        //modal
        $coa_aktivas = MasterCoa::with('children')->where('kode_coa','like','3%')->get();

        foreach ($coa_aktivas as $key2 => $coa) {
            # code...
            $jurnal_umum_debet = JurnalUmum::where('akun',$coa->kode_coa)->where('identitas_koperasi_id',$request->identitas_koperasi_id)->whereBetween('tanggal',[$tanggal_awal2,$tanggal_akhir2])->where('d_k','debet')->get()->sum('nominal');
            $jurnal_umum_kredit = JurnalUmum::where('akun',$coa->kode_coa)->where('identitas_koperasi_id',$request->identitas_koperasi_id)->whereBetween('tanggal',[$tanggal_awal2,$tanggal_akhir2])->where('d_k','kredit')->get()->sum('nominal');

            $nom_coa = 0;

            $laporan_shu [] = [
                'coa' => 'modal',
                'data' => $coa->toArray(),
                'nominal' => abs($nom_coa + round($jurnal_umum_debet - $jurnal_umum_kredit,2))
            ];
        }

        // shu tahun lalu
        $tgl_awal2 = $tanggal_awal2;
        $tgl_akhir2 = (date('Y',strtotime($tanggal_akhir2)) - 1).'-12-31';
        $perhit = $this->perhitungan_shu($tgl_awal2,$tgl_akhir2,$request->identitas_koperasi_id);

        $perhit = array_values($perhit['tot_lap_shu_rentang']);
        $tot_lap_shu_ren = $perhit[0] - $perhit[1];

        $laporan_shu [] = [
            'coa' => 'shu',
            'data' => $perhit,
            'nominal' => $tot_lap_shu_ren
        ];

        // shu saat ini
        $tgl_awal2 = (date('Y',strtotime($tanggal_akhir2))).'-01-01';
        $tgl_akhir2 = $tanggal_akhir2;
        $perhit = $this->perhitungan_shu($tgl_awal2,$tgl_akhir2,$request->identitas_koperasi_id);

        $perhit = array_values($perhit['tot_lap_shu_rentang']);
        $tot_lap_shu_ren = $perhit[0] - $perhit[1];

        $laporan_shu [] = [
            'coa' => 'shu',
            'data' => $perhit,
            'nominal' => $tot_lap_shu_ren
        ];

        $laporan_shu_new  = [];
        foreach ($laporan_shu as $key => $value) {
            # code...
            $laporan_shu_new [$value['coa']][] = $value;
        }

        $tot_lap_shu = [];
        $tot_lap_shu['aset_lancar'] = 0;
        $tot_lap_shu['aset_tidak_lancar'] = 0;
        $tot_lap_shu['aset_tetap'] = 0;
        $tot_lap_shu['aset_lainnya'] = 0;
        $tot_lap_shu['hutang_lancar'] = 0;
        $tot_lap_shu['hutang_jangka_panjang'] = 0;
        $tot_lap_shu['modal'] = 0;
        $tot_lap_shu['shu'] = 0;

        foreach ($laporan_shu as $key => $value) {
            # code...
            $tot_lap_shu [$value['coa']] += $value['nominal'];
        }

        // $final

        $final_total = [];
        $final_total['aset'] = $tot_lap_shu['aset_lancar'] + $tot_lap_shu['aset_tidak_lancar'] + $tot_lap_shu['aset_tetap'] + $tot_lap_shu['aset_lainnya'];
        $final_total['hutang_dan_modal'] = $tot_lap_shu['hutang_lancar'] + $tot_lap_shu['hutang_jangka_panjang'] + $tot_lap_shu['modal'] + $tot_lap_shu['shu'] ;
        // $data['meta'] = array('status' => true, 'message' => 'Success');
        $data['data'] = array('final_total' => $final_total,'laporan_shu' => $laporan_shu_new,'total_laporan_shu' => $tot_lap_shu);
        $data['akuntansi'] = $data['data'];

        $data['identitas'] = $identitas;

        $data['tgl_awal'] = $request->tgl_awal;
        $data['tgl_akhir'] = $request->tgl_akhir;

        // dd($data);
        return view('cetak.laporan-alk',$data);
    }
}
