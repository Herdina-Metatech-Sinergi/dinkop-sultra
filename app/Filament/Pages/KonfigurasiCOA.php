<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class KonfigurasiCOA extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.konfigurasi-coa';

    protected static ?string $title = 'Konfigurasi COA';

    protected static ?string $navigationGroup = 'Master Data';

    public function mount(): void
    {
        abort_unless(auth()->user()->hasRole(['Admin Dinkop']), 403);
    }

    // Menyembunyikan menu untuk role tertentu
    public static function shouldRegisterNavigation(): bool
    {
        // Hanya menampilkan menu jika pengguna memiliki role 'Admin Dinkop'
        return auth()->user()->hasRole('Admin Dinkop');
    }

}
