<?php

namespace App\Filament\Resources\AnggotaKoperasiResource\Pages;

use App\Filament\Resources\AnggotaKoperasiResource;
use App\Filament\Resources\AnggotaKoperasiResource\Widgets\AnggotaKoperasiDetailWidget;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAnggotaKoperasi extends EditRecord
{
    protected static string $resource = AnggotaKoperasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }


    protected function getFooterWidgets(): array
    {
        return [
            AnggotaKoperasiDetailWidget::class,
        ];
    }
}
