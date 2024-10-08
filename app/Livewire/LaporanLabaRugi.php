<?php

namespace App\Livewire;

use App\Models\IdentitasKoperasi;
use App\Models\JurnalUmum;
use Carbon\Carbon;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Livewire\Component;

class LaporanLabaRugi extends Component implements HasForms
{
    use InteractsWithForms;

    public $filters = [
        'tgl_awal' => null,
        'tgl_akhir' => null,
        'identitas_koperasi_id' => null,
    ];

    public function getFilterFormSchema(Form $form): Form
    {
        return $form
            ->schema([Grid::make(3)->schema([
                    TextInput::make('filters.tgl_awal')->lazy()
                        ->required()
                        ->type('date'),
                    TextInput::make('filters.tgl_akhir')->lazy()
                        ->required()
                        ->type('date'),
                    Select::make('filters.identitas_koperasi_id')->options(function () {
                        // Cek apakah user memiliki role "Admin"
                        if (auth()->user()->hasRole('Admin')) {
                            // Jika user adalah Admin, tampilkan semua opsi
                            return IdentitasKoperasi::get()->pluck('nama_koperasi', 'id');
                        } else {
                            // Jika bukan Admin, tampilkan opsi yang sesuai dengan kondisi tertentu
                            return IdentitasKoperasi::where('user_id', auth()->user()->id)
                                                    ->pluck('nama_koperasi', 'id');
                        }
                    })->searchable()->required()
            ])])->model(JurnalUmum::class);
    }

    public function formValidation()
    {
        // Backend validation
        $this->validate(
            [
                'filters.tgl_awal' => 'required',
                'filters.tgl_akhir' => 'required',
                'filters.identitas_koperasi_id' => 'required',
            ],
            [],
            [
                'filters.tgl_awal' => 'Tanggal awal',
                'filters.tgl_akhir' => 'Tanggal akhir',
                'filters.identitas_koperasi_id' => 'Identitas Koperasi',
            ]
        );
    }

    protected function getForms(): array
    {
        return [
            'getFilterFormSchema',
        ];
    }

    public function exportPDF()
    {
        try {
            $this->formValidation();

            $tgl_awal = Carbon::parse($this->filters['tgl_awal']);
            $tgl_akhir = Carbon::parse($this->filters['tgl_akhir']);


            $_url = '/admin/cetak/laporan-laba-rugi?tgl_awal=' . $tgl_awal->toDateString() . '&tgl_akhir=' . $tgl_akhir->toDateString() . '&identitas_koperasi_id=' . $this->filters['identitas_koperasi_id'];
            return redirect($_url);
            // $this->dispatch('download-export', $_url);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function render()
    {
        return view('livewire.laporan-laba-rugi');
    }
}
