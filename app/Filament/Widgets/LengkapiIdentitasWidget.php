<?php

namespace App\Filament\Widgets;

use App\Models\IdentitasKoperasi;
use Filament\Widgets\Widget;

class LengkapiIdentitasWidget extends Widget
{
    protected static string $view = 'filament.widgets.lengkapi-identitas-widget';

    protected int | string | array $columnSpan = 2; // Full Width
    public $data; // Properti untuk menyimpan data

    public function mount()
    {
        // Anda bisa mengambil data dari database atau logika lain di sini
        $this->data = [
            'identitas' => IdentitasKoperasi::where('user_id',auth()->user()->id)->first(),
        ];
    }

    // Fungsi viewData untuk mengirim data ke view
    protected function viewData(): array
    {
        return [
            'data' => $this->data, // Mengirim data ke view
        ];
    }
}
