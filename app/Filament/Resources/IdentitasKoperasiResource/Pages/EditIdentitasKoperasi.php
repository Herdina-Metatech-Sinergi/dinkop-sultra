<?php

namespace App\Filament\Resources\IdentitasKoperasiResource\Pages;

use App\Filament\Resources\IdentitasKoperasiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIdentitasKoperasi extends EditRecord
{
    protected static string $resource = IdentitasKoperasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
