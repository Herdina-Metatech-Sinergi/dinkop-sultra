<?php

namespace App\Filament\Resources\TransaksiUmumResource\Pages;

use App\Filament\Resources\TransaksiUmumResource;
use App\Http\Controllers\Controller;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTransaksiUmum extends CreateRecord
{
    protected static string $resource = TransaksiUmumResource::class;

    protected function afterCreate(): void
    {
        $record = $this->record;

        $controller = new Controller();

        $controller->jurnal_umum($record->konfigurasi_coa,$record->nominal,null,null,null,$record->tanggal.' '.date('H:i:s'),null,$record->identitas_koperasi_id);

    }
}
