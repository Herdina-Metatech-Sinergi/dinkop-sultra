<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class LaporanArusKas extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.laporan-arus-kas';

    protected static ?string $navigationGroup = 'Laporan';
    protected static ?string $navigationLabel = 'Laporan Arus Kas';

}
