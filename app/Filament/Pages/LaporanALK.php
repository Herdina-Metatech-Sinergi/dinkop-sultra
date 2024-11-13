<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class LaporanALK extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.laporan-a-l-k';

    protected static ?string $navigationGroup = 'Laporan';

    protected static ?string $navigationLabel = 'Laporan ALK';
    protected static ?int $navigationSort = 5;
}
