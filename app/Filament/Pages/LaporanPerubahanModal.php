<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class LaporanPerubahanModal extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.laporan-perubahan-modal';

    protected static ?string $navigationGroup = 'Laporan';
    protected static ?int $navigationSort = 2;


}
