<?php

namespace App\Livewire;

use App\Models\IdentitasKoperasi;
use Carbon\Carbon;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;

class LaporanALK extends Component implements HasForms
{
    use InteractsWithForms;

    public $filters = [
        'tgl_awal' => null,
        'tgl_akhir' => null,
        'identitas_koperasi_id' => null,
    ];

    public function mount(){
        if (auth()->user()->hasRole('Admin Dinkop')) {
            $firstOption = IdentitasKoperasi::get()->pluck('id')->first();
        } else {
            $firstOption = IdentitasKoperasi::where('user_id', auth()->user()->id)
                                            ->pluck('id')
                                            ->first();
        }

        $this->filters['identitas_koperasi_id']  = $firstOption;
    }

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
                        if (auth()->user()->hasRole('Admin Dinkop')) {
                            // Jika user adalah Admin, tampilkan semua opsi
                            $options = IdentitasKoperasi::get()->pluck('nama_koperasi', 'id');
                        } else {
                            // Jika bukan Admin, tampilkan opsi yang sesuai dengan kondisi tertentu
                            $options = IdentitasKoperasi::where('user_id', auth()->user()->id)
                                                        ->pluck('nama_koperasi', 'id');
                        }

                        return $options;
                    })
                    ->default(function () {

                        // Dapatkan nilai ID pertama dari query berdasarkan role user
                        if (auth()->user()->hasRole('Admin Dinkop')) {
                            $firstOption = IdentitasKoperasi::get()->pluck('id')->first();
                        } else {
                            $firstOption = IdentitasKoperasi::where('user_id', auth()->user()->id)
                                                            ->pluck('id')
                                                            ->first();
                        }

                        return $firstOption;
                    })->searchable()->required()->label('Identitas Koperasi')
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


            $_url = '/admin/cetak/laporan-alk?tgl_awal=' . $tgl_awal->toDateString() . '&tgl_akhir=' . $tgl_akhir->toDateString() . '&identitas_koperasi_id=' . $this->filters['identitas_koperasi_id'];
            return redirect($_url);
            // $this->dispatch('download-export', $_url);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function render()
    {
        return view('livewire.laporan-a-l-k');
    }
}
