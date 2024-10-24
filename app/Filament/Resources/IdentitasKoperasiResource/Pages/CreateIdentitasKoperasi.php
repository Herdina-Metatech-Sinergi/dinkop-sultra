<?php

namespace App\Filament\Resources\IdentitasKoperasiResource\Pages;

use App\Filament\Resources\IdentitasKoperasiResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateIdentitasKoperasi extends CreateRecord
{
    protected static string $resource = IdentitasKoperasiResource::class;

    public function mount(): void
    {
        abort_unless(auth()->user()->hasRole(['Admin Dinkop']), 403);
    }
}
