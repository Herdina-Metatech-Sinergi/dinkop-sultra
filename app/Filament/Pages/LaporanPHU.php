<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class LaporanPHU extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.laporan-laba-rugi';

    protected static ?string $navigationGroup = 'Laporan';
    protected static ?string $navigationLabel = 'Laporan PHU';


}
