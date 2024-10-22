<?php

namespace App\Filament\Resources\TransaksiUmumResource\Pages;

use App\Filament\Resources\TransaksiUmumResource;
use App\Http\Controllers\Controller;
use App\Models\JurnalUmum;
use App\Models\MasterCoa;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTransaksiUmum extends CreateRecord
{
    protected static string $resource = TransaksiUmumResource::class;

    protected function afterCreate(): void
    {
        $record = $this->record;

        //menambah data ke jurnal umum


        $date = $record->tanggal;

            # code...
        $identitas_koperasi_id =  $record->identitas_koperasi_id;

        $jurnal =  date('YmdHis', strtotime($date)) .'#'.($kon[0]->id??'0'). '#' . $identitas_koperasi_id . '#' . auth()->user()->id.'#'.($anggota->id ?? 0);

        $key = MasterCoa::where('kode_coa',$record->konfigurasi_coa)->first();

        JurnalUmum::updateOrCreate([
            'jurnal' => $jurnal_kode ?? $jurnal,
            'akun' => $key->kode_coa,
        ],[
            'tanggal' => $date,
            'deskripsi' => $key->title.' '.$record->deskripsi,
            'akun' => $key->kode_coa,
            'd_k' => 'debet',
            'nominal' => $record->nominal,
            'user_id' => auth()->user()->id,
            'jurnal' => $jurnal_kode ?? $jurnal,
            'identitas_koperasi_id' => $identitas_koperasi_id
        ]);

        $key = MasterCoa::where('title','Kas')->first();

        JurnalUmum::updateOrCreate([
            'jurnal' => $jurnal_kode ?? $jurnal,
            'akun' => $key->kode_coa,
        ],[
            'tanggal' => $date,
            'deskripsi' => $key->title,
            'akun' => $key->kode_coa,
            'd_k' => 'kredit',
            'nominal' => $record->nominal,
            'user_id' => auth()->user()->id,
            'jurnal' => $jurnal_kode ?? $jurnal,
            'identitas_koperasi_id' => $identitas_koperasi_id
        ]);

    }
}
