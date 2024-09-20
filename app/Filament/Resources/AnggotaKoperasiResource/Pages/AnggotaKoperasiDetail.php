<?php

namespace App\Filament\Resources\AnggotaKoperasiResource\Pages;

use App\Filament\Resources\AnggotaKoperasiResource;
use Filament\Resources\Pages\Page;

class AnggotaKoperasiDetail extends Page
{
    protected static string $resource = AnggotaKoperasiResource::class;

    protected static string $view = 'filament.resources.anggota-koperasi-resource.pages.anggota-koperasi-detail';

    public $anggotaId;

    public function mount($record): void
    {
        $this->anggotaId = $record;
    }
}
