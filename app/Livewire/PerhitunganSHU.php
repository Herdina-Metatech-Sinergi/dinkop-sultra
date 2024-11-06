<?php

namespace App\Livewire;

use App\Http\Controllers\CetakController;
use App\Models\AnggotaKoperasi;
use App\Models\IdentitasKoperasi;
use App\Models\KreditAngsuran;
use App\Models\KreditKonvensionalAngsuran;
use App\Models\MasterBagianSHU;
use App\Models\SimpananPokokAnggota;
use App\Models\SimpananWajibAnggota;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;

class PerhitunganSHU extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public $filters = [
        'bagian_anggota' => null,
        'transaksi' => null,
        'simpanan' => null,
        'tgl_awal' => null,
        'tgl_akhir' => null,
        'identitas_koperasi_id' => null,
    ];

    public $shu_bag_anggota = 0;
    public $shu_transaksi = 0;
    public $shu_simpanan = 0;
    public $shu;
    public $total_simpanan = 0;
    public $total_transaksi = 0;
    public $anggota_koperasi = [];

    public function mount(){
        if (auth()->user()->hasRole('Admin Dinkop')) {
            $firstOption = IdentitasKoperasi::get()->pluck('id')->first();
        } else {
            $firstOption = IdentitasKoperasi::where('user_id', auth()->user()->id)
                                            ->pluck('id')
                                            ->first();
        }

        $this->filters['identitas_koperasi_id']  = $firstOption;
        $this->filters['tgl_awal']  = date('Y').'-01-01';
        $this->filters['tgl_akhir']  = date('Y-m-d');

        $mbs = MasterBagianSHU::where('identitas_koperasi_id',$firstOption)->first();

        if ($mbs) {
            # code...
            $this->filters['bagian_anggota']  = $mbs->shu_bagian_anggota;
            $this->filters['simpanan']  = $mbs->shu_untuk_simpanan;
            $this->filters['transaksi']  = $mbs->shu_untuk_transaksi;

        }
    }

    public function getFilterFormSchema(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)->schema([
                    TextInput::make('filters.bagian_anggota')->lazy()
                        ->label('SHU Bagian Anggota (%)')
                        ->required()
                        ->numeric(),
                    TextInput::make('filters.simpanan')->lazy()
                        ->label('SHU Bagian Anggota - Simpanan (%)')
                        ->required()
                        ->numeric(),
                    TextInput::make('filters.transaksi')->lazy()
                        ->label('SHU Bagian Anggota - Transaksi (%)')
                        ->required()
                        ->numeric(),

                ]),
                Grid::make(3)->schema([
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
                ])

            ])->model(JurnalUmum::class);
    }

    public function formValidation()
    {
        // Backend validation
        $this->validate(
            [
                'filters.bagian_anggota' => 'required',
                'filters.transaksi' => 'required',
                'filters.simpanan' => 'required',
                'filters.tgl_awal' => 'required',
                'filters.tgl_akhir' => 'required',
                'filters.identitas_koperasi_id' => 'required',
            ],
            [],
            [
                'filters.bagian_anggota' => 'Bagian anggota',
                'filters.simpanan' => 'Simpanan',
                'filters.transaksi' => 'Transaksi',
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

    public function viewSHU(){
        $this->formValidation();

        $filters = $this->filters;

        $cetakController = new CetakController();
        $shu = $cetakController->perhitungan_shu($filters['tgl_awal'],$filters['tgl_akhir'],$filters['identitas_koperasi_id']);
        $shu = $shu['tot_lap_shu_rentang'][4] ?? 0;
        $this->shu = $shu;

        //SHU Bag Anggota
        $this->shu_bag_anggota = $shu * $filters['bagian_anggota'] / 100;

        //SHU simpanan
        $this->shu_simpanan = $this->shu_bag_anggota * $filters['simpanan'] / 100;

        //SHU transaksi
        $this->shu_transaksi = $this->shu_bag_anggota * $filters['transaksi'] / 100;

        // total simpanan
        $total = 0;
        $sim = SimpananPokokAnggota::whereHas('anggota_koperasi', function($query){
            $query->where('identitas_koperasi_id',$this->filters['identitas_koperasi_id']);
        })->get();

        foreach ($sim as $key => $value) {
            # code...
            if ($value['d_k'] == 'Debet') {
                $total += $value['nominal'];
            }

            if ($value['d_k'] == 'Kredit') {
                $total -= $value['nominal'];
            }

        }

        $sim = SimpananWajibAnggota::whereHas('anggota_koperasi', function($query){
            $query->where('identitas_koperasi_id',$this->filters['identitas_koperasi_id']);
        })->get();

        foreach ($sim as $key => $value) {
            # code...
            if ($value['d_k'] == 'Debet') {
                $total += $value['nominal'];
            }

            if ($value['d_k'] == 'Kredit') {
                $total -= $value['nominal'];
            }

        }

        $this->total_simpanan = $total;

        // total transaksi
        $total = 0;
        $sim = KreditAngsuran::whereHas('kredit.anggota_koperasi', function($query){
            $query->where('identitas_koperasi_id',$this->filters['identitas_koperasi_id']);
        })->where('status_bunga','Lunas')->get();

        foreach ($sim as $key => $value) {
            # code...
            $total += $value['nominal_bunga'];
        }

        $sim = KreditKonvensionalAngsuran::whereHas('kredit_konvensional.anggota_koperasi', function($query){
            $query->where('identitas_koperasi_id',$this->filters['identitas_koperasi_id']);
        })->where('status_bunga','Lunas')->get();

        foreach ($sim as $key => $value) {
            # code...
            $total += $value['angsuran_bunga'];
        }

        $this->total_transaksi = $total;

        $this->anggota_koperasi = AnggotaKoperasi::where('identitas_koperasi_id',$filters['identitas_koperasi_id'])->get()->toArray();

        foreach ($this->anggota_koperasi as $key2 => $value2) {
            # code...
            $total = 0;
            $sim = SimpananPokokAnggota::where('anggota_koperasi_id',$value2['id'])->get();

            foreach ($sim as $key => $value) {
                # code...
                if ($value['d_k'] == 'Debet') {
                    $total += $value['nominal'];
                }

                if ($value['d_k'] == 'Kredit') {
                    $total -= $value['nominal'];
                }

            }

            $sim = SimpananWajibAnggota::where('anggota_koperasi_id',$value2['id'])->get();

            foreach ($sim as $key => $value) {
                # code...
                if ($value['d_k'] == 'Debet') {
                    $total += $value['nominal'];
                }

                if ($value['d_k'] == 'Kredit') {
                    $total -= $value['nominal'];
                }

            }

            $this->anggota_koperasi[$key2]['total_simpanan'] = $total;


            $total = 0;
            $sim = KreditAngsuran::whereHas('kredit', function($query) use ($value2){
                $query->where('anggota_koperasi_id',$value2['id']);
            })->where('status_bunga','Lunas')->get();

            foreach ($sim as $key => $value) {
                # code...
                $total += $value['nominal_bunga'];
            }

            $sim = KreditKonvensionalAngsuran::whereHas('kredit_konvensional', function($query) use ($value2){
                $query->where('anggota_koperasi_id',$value2['id']);
            })->where('status_bunga','Lunas')->get();

            foreach ($sim as $key => $value) {
                # code...
                $total += $value['angsuran_bunga'];
            }

            $this->anggota_koperasi[$key2]['total_transaksi'] = $total;
        }

        // dd($this);
    }

    public function render()
    {
        return view('livewire.perhitungan-s-h-u');
    }
}
