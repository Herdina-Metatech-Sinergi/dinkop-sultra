<?php

namespace App\Filament\Resources\TransaksiUmumResource\Pages;

use App\Filament\Resources\TransaksiUmumResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTransaksiUmum extends EditRecord
{
    protected static string $resource = TransaksiUmumResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
