<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class LaporanAkun extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.laporan-akun';

    protected static ?string $navigationGroup = 'Laporan';
    protected static ?string $navigationLabel = 'Laporan Akun';
    protected static ?int $navigationSort = 1;



}
