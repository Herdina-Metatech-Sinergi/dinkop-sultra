<?php

namespace App\Filament\Resources\MasterBagianSHUResource\Pages;

use App\Filament\Resources\MasterBagianSHUResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMasterBagianSHUS extends ListRecords
{
    protected static string $resource = MasterBagianSHUResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
