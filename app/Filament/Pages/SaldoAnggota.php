<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class SaldoAnggota extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.saldo-anggota';

    protected static ?string $navigationGroup = 'Laporan';
    protected static ?string $navigationLabel = 'Simpanan Anggota';

}
