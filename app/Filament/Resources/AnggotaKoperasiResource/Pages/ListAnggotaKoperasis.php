<?php

namespace App\Filament\Resources\AnggotaKoperasiResource\Pages;

use App\Filament\Resources\AnggotaKoperasiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAnggotaKoperasis extends ListRecords
{
    protected static string $resource = AnggotaKoperasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
