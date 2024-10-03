<?php

namespace App\Filament\Resources\AnggotaKoperasiResource\Pages;

use App\Filament\Resources\AnggotaKoperasiResource;
use App\Models\AnggotaKoperasi;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAnggotaKoperasi extends CreateRecord
{
    protected static string $resource = AnggotaKoperasiResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // dd($data);
        if ($data['no_anggota'] == null) {
            # code...
            $cek_urutan = AnggotaKoperasi::where(['identitas_koperasi_id' => $data['identitas_koperasi_id']])->whereYear('created_at',date('Y'))->count() + 1;
            $no_anggota = $data['identitas_koperasi_id'].date('Y').str_pad($cek_urutan, 5, '0', STR_PAD_LEFT);
            $data['no_anggota'] = $no_anggota;
        }

        return $data;
    }
}
