<?php

namespace App\Livewire;

use App\Http\Controllers\Controller;
use App\Models\AnggotaKoperasi;
use App\Models\IdentitasKoperasi;
use App\Models\Kredit;
use App\Models\KreditAngsuran;
use App\Models\KreditKonvensional;
use App\Models\SimpananLainnyaAnggota;
use App\Models\SimpananNonModalData;
use App\Models\SimpananNonModalMenu;
use App\Models\SimpananPokokAnggota;
use App\Models\SimpananSukarelaAnggota;
use App\Models\SimpananWajibAnggota;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Livewire\Component;

class AnggotaKoperasiDetail extends Component implements HasForms
{
    use InteractsWithForms;

    public $anggota_id;
    public $anggota;

    public $simpok_id;
    public $simwa_id;
    public $simsem_id;
    public $kredit_id;
    public $simla_id;

    // public $nominal,$tanggal;

    public ?array $data = [];
    public $non_modal_menus = [];
    public $new_menu_name;
    public $menu_id;

    public $angsuran = [];


    public function mount($anggota_id){
        $this->anggota_id = $anggota_id;

        // Fetch anggota details and menus
        $this->anggota = AnggotaKoperasi::where('id', $anggota_id)->first();
        $this->non_modal_menus = SimpananNonModalMenu::all();  // Fetch existing dynamic menus

        $this->anggota = AnggotaKoperasi::where('id',$anggota_id)->first();
        $this->formHeader->fill();
        $this->formSimpananPokok->fill();
        $this->formSimpananLainnya->fill();
        $this->formSimpananWajib->fill();
        $this->formSimpananSukarela->fill();
        $this->formKredit->fill();

        $this->menu_id = SimpananNonModalMenu::first()->id ?? null;

        $kredit = Kredit::with('kredit_angsuran')->where('anggota_koperasi_id',$this->anggota_id)->where('kredit','Flat')->get();
        foreach ($kredit as $key => $value) {
            # code...
            foreach ($value['kredit_angsuran'] as $key2 => $value2) {
                # code...
                $this->angsuran[$value2['id']] = [
                    'tanggal_jatuh_tempo' => $value2['tanggal_jatuh_tempo'],
                    'nominal_pokok' => $value2['nominal_pokok'],
                ];
            }
        }

    }

    public function setMenu($menu_id){
        $this->menu_id = $menu_id;
    }
    // Function to add new dynamic menu
    public function addNewMenu()
    {
        $this->validate([
            'new_menu_name' => 'required|string|max:255',
        ]);

        // Create new menu in the database
        $menu = SimpananNonModalMenu::create(['nama_menu' => $this->new_menu_name,'identitas_koperasi_id' => $this->anggota->identitas_koperasi_id]);

        // Refresh menus
        $this->non_modal_menus = SimpananNonModalMenu::all();

        // Clear input
        $this->new_menu_name = '';

        if (SimpananNonModalMenu::count() == 1) {
            # code...
            $this->menu_id = $menu->id;
        }

        Notification::make()->title('Menu baru berhasil ditambahkan!')->success()->send();
    }

    // Forms for each menu will be generated dynamically
    public function formSimpananNonModal(Form $form): Form
    {
        return $form->schema([
            Grid::make(4)->schema([
                TextInput::make('nominal')->numeric()->required(),
                DatePicker::make('tanggal')->required(),
                Select::make('d_k')->label('Stor/Tarik')->options(['Debet' => 'Stor', 'Kredit' => 'Tarik'])->required(),
                TextInput::make('deskripsi'),
            ]),
        ])->model(SimpananNonModalData::class)
          ->statePath('data_' . $this->menu_id);  // Different state for each menu
    }

    // Submit form for each dynamic menu
    public function submitSimpananNonModal()
    {

        $data = $this->formSimpananSukarela->getState();
        $data['anggota_koperasi_id'] = $this->anggota_id;
        $data['menu_id'] = $this->menu_id;


        if ($this->simsem_id) {
            # code...
            unset($data['tanggal']);

            $simpok = SimpananNonModalData::where('id',$this->simsem_id)->update($data);
            $simpok = SimpananNonModalData::where('id',$this->simsem_id)->first();

        }else{
            $cek = SimpananNonModalData::where('anggota_koperasi_id',$this->anggota_id)->latest()->first();
            if (@$cek->tanggal > $data['tanggal']) {
                # code...
                return Notification::make()->title('Gagal disubmit, tanggal tidak boleh kurang dari transaksi terakhir!')->danger()->send();
            }
            $simpok = SimpananNonModalData::create($data);

        }

        $controller = new Controller();
        if ($data['d_k'] == 'Debet') {

            $controller->jurnal_umum('Bayar Simpanan Non Modal',$data['nominal'],$this->anggota_id,null,null,$simpok->created_at);
        }else{
            $controller->jurnal_umum('Bayar Simpanan Non Modal Tarik',$data['nominal'],$this->anggota_id,null,null,$simpok->created_at);

        }
        $this->simpok_id = null;
        $this->simwa_id = null;
        $this->simsem_id = null;
        $this->formHeader->fill();
        $this->formSimpananPokok->fill();
        $this->formSimpananWajib->fill();
        $this->formSimpananLainnya->fill();

        $this->formSimpananSukarela->fill();
        $this->formSimpananSukarelaJasa->fill();
        $this->formSimpananSukarelaAdmin->fill();
        return Notification::make()->title('Berhasil disubmit!')->success()->send();
    }


    // Submit form for each dynamic menu
    public function submitSimpananNonModalJasa()
    {

        $data = $this->formSimpananSukarelaJasa->getState();
        $data['anggota_koperasi_id'] = $this->anggota_id;
        $data['menu_id'] = $this->menu_id;

        $data['d_k'] = 'Debet';
        $data['nominal'] = $data['nominal_jasa'];
        $data['tanggal'] = date('Y-m-d');
        $data['deskripsi'] = 'Jasa Tahunan : '.$data['tingkat_bunga'].'%';

        unset($data['tanggal_akhir']);
        unset($data['saldo_akhir']);
        unset($data['tingkat_bunga']);
        unset($data['nominal_jasa']);

        $cek = SimpananNonModalData::where('anggota_koperasi_id',$this->anggota_id)->latest()->first();
        if (@$cek->tanggal > $data['tanggal']) {
            # code...
            return Notification::make()->title('Gagal disubmit, tanggal tidak boleh kurang dari transaksi terakhir!')->danger()->send();
        }
        $simpok = SimpananNonModalData::create($data);


        $controller = new Controller();
        if ($data['d_k'] == 'Debet') {

            $controller->jurnal_umum('Bayar Simpanan Non Modal Bunga',$data['nominal'],$this->anggota_id,null,null,$simpok->created_at);
        }
        $this->simpok_id = null;
        $this->simwa_id = null;
        $this->simsem_id = null;
        $this->formHeader->fill();
        $this->formSimpananPokok->fill();
        $this->formSimpananWajib->fill();
        $this->formSimpananLainnya->fill();

        $this->formSimpananSukarela->fill();
        $this->formSimpananSukarelaJasa->fill();
        $this->formSimpananSukarelaJasaAdmin->fill();
        return Notification::make()->title('Berhasil disubmit!')->success()->send();
    }

    public function submitSimpananNonModalAdmin()
    {

        $data = $this->formSimpananSukarelaAdmin->getState();
        $data['anggota_koperasi_id'] = $this->anggota_id;
        $data['menu_id'] = $this->menu_id;

        $data['d_k'] = 'Kredit';
        $data['nominal'] = $data['nominal_admin'];
        $data['tanggal'] = date('Y-m-d');
        $data['deskripsi'] = 'Admin Bulanan : '.$data['tanggal'];

        unset($data['tanggal_akhir']);
        unset($data['saldo_akhir']);
        unset($data['tingkat_bunga']);
        unset($data['nominal_admin']);

        $cek = SimpananNonModalData::where('anggota_koperasi_id',$this->anggota_id)->latest()->first();
        if (@$cek->tanggal > $data['tanggal']) {
            # code...
            return Notification::make()->title('Gagal disubmit, tanggal tidak boleh kurang dari transaksi terakhir!')->danger()->send();
        }
        $simpok = SimpananNonModalData::create($data);


        $controller = new Controller();
        if ($data['d_k'] == 'Kredit') {

            $controller->jurnal_umum('Bayar Simpanan Non Modal Bunga Tarik',$data['nominal'],$this->anggota_id,null,null,$simpok->created_at);
        }
        $this->simpok_id = null;
        $this->simwa_id = null;
        $this->simsem_id = null;
        $this->formHeader->fill();
        $this->formSimpananPokok->fill();
        $this->formSimpananWajib->fill();
        $this->formSimpananLainnya->fill();

        $this->formSimpananSukarela->fill();
        $this->formSimpananSukarelaJasa->fill();
        $this->formSimpananSukarelaAdmin->fill();
        return Notification::make()->title('Berhasil disubmit!')->success()->send();
    }


    protected function getForms(): array
    {
        return [
            'formHeader',
            'formSimpananPokok',
            'formSimpananLainnya',
            'formSimpananWajib',
            'formSimpananSukarela',
            'formSimpananSukarelaJasa',
            'formSimpananSukarelaAdmin',
            'formKredit',
            'formSimpananNonModal'
        ];
    }

    public function formHeader(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(4)
                ->schema([
                    Placeholder::make('anggota.no_anggota')
                        ->label('No Anggota')
                        ->content(function (callable $get) {
                            return $this->anggota['no_anggota'] ?? '-';
                        }),
                    Placeholder::make('anggota.nama')
                        ->label('Nama')
                        ->content(function (callable $get) {
                            return $this->anggota['nama'] ?? '-';
                        }),
                    Placeholder::make('anggota.alamat')
                        ->label('Alamat')
                        ->content(function (callable $get) {
                            return $this->anggota['alamat'] ?? '-';
                        }),
                    Placeholder::make('anggota.tgl_lahir')
                        ->label('Tanggal Lahir')
                        ->content(function (callable $get) {
                            return $this->anggota['tgl_lahir'] ?? '-';
                        }),

                ]),

            ])
            ->model(SimpananPokokAnggota::class)->statePath('data');
    }

    public function prosesAnggotaKeluar(){
        $tgl = date('Y-m-d');
        $anggota_id = $this->anggota_id;

        // cek pinjaman dia dulu
        $kredit = Kredit::with('kredit_angsuran')->where('anggota_koperasi_id',$anggota_id)->get();

        $flag = false;
        foreach ($kredit as $key => $value) {
            # code...
            foreach ($value->kredit_angsuran as $key2 => $value2) {
                # code...
                if ($value2->status_pokok == 'Belum Lunas') {
                    # code...
                    $flag = true;
                }

                if ($value2->status_bunga == 'Belum Lunas') {
                    # code...
                    $flag = true;
                }
            }
        }

        if ($flag) {
            # code...
            return Notification::make()->title('Gagal, anggota masih dalam masa pinjaman Flat yang belum tuntas!')->danger()->send();

        }

        // cek pinjaman dia dulu
        $kredit = KreditKonvensional::with('kredit_konvensional_angsuran')->where('anggota_koperasi_id',$anggota_id)->get();

        $flag = false;
        foreach ($kredit as $key => $value) {
            # code...
            foreach ($value->kredit_konvensional_angsuran as $key2 => $value2) {
                # code...
                if ($value2->status_pokok == 'Belum Lunas') {
                    # code...
                    $flag = true;
                }

                if ($value2->status_bunga == 'Belum Lunas') {
                    # code...
                    $flag = true;
                }
            }
        }

        if ($flag) {
            # code...
            return Notification::make()->title('Gagal, anggota masih dalam masa pinjaman Konvensional yang belum tuntas!')->danger()->send();

        }

        // simpanan pokok
        $total = 0;
        $sim = SimpananPokokAnggota::where('anggota_koperasi_id',$anggota_id)->get();
        foreach ($sim as $key => $value) {
            # code...
            if ($value['d_k'] == 'Debet') {
                $total += $value['nominal'];
            }

            if ($value['d_k'] == 'Kredit') {
                $total -= $value['nominal'];
            }

        }
        if ($total != 0) {
            # code...
            $data = [
                'tanggal' => $tgl,
                'nominal' => $total,
                'd_k' => 'Kredit',
                'deskripsi' => 'Keluar dari Anggota Koperasi',
                'anggota_koperasi_id' => $anggota_id
            ];

            $simpok = SimpananPokokAnggota::create($data);

            $controller = new Controller();
            $controller->jurnal_umum('Bayar Simpanan Pokok Tarik',$total,$this->anggota_id,null,null,null);

        }

        // simpanan wajib
        $total = 0;
        $sim = SimpananWajibAnggota::where('anggota_koperasi_id',$anggota_id)->get();
        foreach ($sim as $key => $value) {
            # code...
            if ($value['d_k'] == 'Debet') {
                $total += $value['nominal'];
            }

            if ($value['d_k'] == 'Kredit') {
                $total -= $value['nominal'];
            }

        }
        if ($total != 0) {
            # code...
            $data = [
                'tanggal' => $tgl,
                'nominal' => $total,
                'd_k' => 'Kredit',
                'deskripsi' => 'Keluar dari Anggota Koperasi',
                'anggota_koperasi_id' => $anggota_id
            ];

            $simpok = SimpananWajibAnggota::create($data);

            $controller = new Controller();
            $controller->jurnal_umum('Bayar Simpanan Wajib Tarik',$total,$this->anggota_id,null,null,null);

        }

        // simpanan lainnya
        $total = 0;
        $sim = SimpananLainnyaAnggota::where('anggota_koperasi_id',$anggota_id)->get();
        foreach ($sim as $key => $value) {
            # code...
            if ($value['d_k'] == 'Debet') {
                $total += $value['nominal'];
            }

            if ($value['d_k'] == 'Kredit') {
                $total -= $value['nominal'];
            }

        }
        if ($total != 0) {
            # code...
            $data = [
                'tanggal' => $tgl,
                'nominal' => $total,
                'd_k' => 'Kredit',
                'deskripsi' => 'Keluar dari Anggota Koperasi',
                'anggota_koperasi_id' => $anggota_id
            ];

            $simpok = SimpananLainnyaAnggota::create($data);

            $controller = new Controller();
            $controller->jurnal_umum('Bayar Simpanan Lainnya Tarik',$total,$this->anggota_id,null,null,null);

        }

        // simpanan non modal lain
        $sim_non = SimpananNonModalData::where('anggota_koperasi_id',$anggota_id)->get()->groupBy('menu_id');

        foreach ($sim_non as $key2 => $value2) {
            # code...
            $total = 0;
            $menu_id = 0;
            foreach ($value2 as $key => $value) {
                # code...
                if ($value['d_k'] == 'Debet') {
                    $total += $value['nominal'];
                }

                if ($value['d_k'] == 'Kredit') {
                    $total -= $value['nominal'];
                }

                $menu_id = $value->menu_id;
            }
            if ($total != 0) {
                # code...

                $data = [
                    'menu_id' => $menu_id,
                    'tanggal' => $tgl,
                    'nominal' => $total,
                    'd_k' => 'Kredit',
                    'deskripsi' => 'Keluar dari Anggota Koperasi',
                    'anggota_koperasi_id' => $anggota_id
                ];

                $simpok = SimpananNonModalData::create($data);

                $controller = new Controller();
                $controller->jurnal_umum('Bayar Simpanan Non Modal Tarik',$total,$this->anggota_id,null,null,null);

            }
        }

        $anggota = AnggotaKoperasi::where('id',$anggota_id)->first();
        $anggota->tgl_keluar = $tgl;
        $anggota->save();

        return Notification::make()->title('Sukses, anggota telah keluar dari keanggotaan koperasi!')->success()->send();

    }

    public function formSimpananPokok(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(4)->schema([TextInput::make('nominal')->numeric()->required(), DatePicker::make('tanggal')->required(), Select::make('d_k')->label('Stor/Tarik')->options(['Debet' => 'Stor', 'Kredit' => 'Tarik'])->required(), TextInput::make('deskripsi'), ]),

            ])
            ->model(SimpananPokokAnggota::class)->statePath('data');
    }

    public function formSimpananLainnya(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(4)->schema([TextInput::make('nominal')->numeric()->required(), DatePicker::make('tanggal')->required(), Select::make('d_k')->label('Stor/Tarik')->options(['Debet' => 'Stor', 'Kredit' => 'Tarik'])->required(), TextInput::make('deskripsi'), ]),

            ])
            ->model(SimpananLainnyaAnggota::class)->statePath('data');
    }

    public function formKredit(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)->schema([
                    TextInput::make('kredit')->readOnly()->label('Jenis Kredit')->default('Flat'),
                    TextInput::make('keterangan')->required()->label('No Pinjaman'),
                    DatePicker::make('tanggal')->required()->label('Tanggal Pinjaman'),
                    TextInput::make('agunan')->label('Agunan')->helperText('Agunan 60% dari pokok pinjaman'),

                ]),
                Grid::make(4)->schema([
                    // Principal Loan Amount (Pinjaman Pokok)
                    TextInput::make('nominal_pinjaman')->numeric()->required()->label('Nominal Pinjaman Pokok')
                    ->afterStateUpdated(function (callable $set, $state, $get) {
                        // Ambil data input dari form
                        $principal = $get('nominal_pinjaman');  // Pinjaman Pokok
                        $interest_rate = $get('interest_rate'); // Suku Bunga (%)
                        $num_installments = $get('num_installments'); // Jangka Waktu (bulan)

                        // Hitung angsuran per bulan
                        if ($principal && $interest_rate && $num_installments) {
                            $monthly_interest = $interest_rate / 100 * $principal;
                            $total_installment = ($principal / $num_installments) + $monthly_interest;

                            // Simpan hasilnya ke angsuran_bulan
                            $set('angsuran_bulan', round($total_installment, 2));
                        }
                    })
                    ->reactive(), // Reactive to trigger recalculation

                    // Interest rate (Suku Bunga)
                    TextInput::make('interest_rate')
                        ->numeric()
                        ->required()
                        ->reactive() // Reactive to trigger recalculation
                        ->afterStateUpdated(function (callable $set, $state, $get) {
                            // Ambil data input dari form
                            $principal = $get('nominal_pinjaman');  // Pinjaman Pokok
                            $interest_rate = $get('interest_rate'); // Suku Bunga (%)
                            $num_installments = $get('num_installments'); // Jangka Waktu (bulan)

                            // Hitung angsuran per bulan
                            if ($principal && $interest_rate && $num_installments) {
                                $monthly_interest = $interest_rate / 100 * $principal;
                                $total_installment = ($principal / $num_installments) + $monthly_interest;

                                // Simpan hasilnya ke angsuran_bulan
                                $set('angsuran_bulan', round($total_installment, 2));
                            }
                        })
                        ->label('Suku Jasa per bulan (%)'),

                    // Number of Installments (Jangka Waktu)
                    TextInput::make('num_installments')
                        ->numeric()
                        ->required()
                        ->reactive() // Reactive to trigger recalculation
                        ->afterStateUpdated(function (callable $set, $state, $get) {
                            // Ambil data input dari form
                            $principal = $get('nominal_pinjaman');  // Pinjaman Pokok
                            $interest_rate = $get('interest_rate'); // Suku Bunga (%)
                            $num_installments = $get('num_installments'); // Jangka Waktu (bulan)

                            // Hitung angsuran per bulan
                            if ($principal && $interest_rate && $num_installments) {
                                $monthly_interest = $interest_rate / 100 * $principal;
                                $total_installment = ($principal / $num_installments) + $monthly_interest;

                                // Simpan hasilnya ke angsuran_bulan
                                $set('angsuran_bulan', round($total_installment, 2));
                            }
                        })
                        ->label('Jangka Waktu (bulan)'),
                        // Monthly Installment (Angsuran/Bulan)
                    TextInput::make('angsuran_bulan')
                        ->numeric()
                        ->disabled()  // This field is calculated, so it's disabled for manual input
                        ->label('Angsuran/Bulan')
                        ->helperText('Kalkulasi Otomatis')
                        ->reactive(),

                ]),
                Grid::make(3)->schema([
                    Select::make('jenis_administrasi')
                        ->label('Jenis Administrasi')
                        ->options([
                            'persen' => 'Administrasi (%)',
                            'rupiah' => 'Administrasi (Rp)',
                        ])
                        ->required()
                        ->default('persen')
                        ->reactive(),

                    TextInput::make('administrasi_persen')
                        ->label('Administrasi (%)')
                        ->numeric()
                        ->default(0)
                        ->required(fn ($get) => $get('jenis_administrasi') === 'persen') // Wajib jika persen dipilih
                        ->hidden(fn ($get) => $get('jenis_administrasi') !== 'persen') // Tersembunyi jika bukan persen
                        ->reactive()
                        ->afterStateUpdated(function (callable $set, $state, $get) {
                            if ($get('jenis_administrasi') === 'persen') {
                                $principal = $get('nominal_pinjaman');
                                $admin = $state;
                                $cadangan = $get('cadangan');

                                if ($principal && $admin && $cadangan) {
                                    $nom_admin = $principal * $admin / 100;
                                    $nom_cadangan = $principal * $cadangan / 100;
                                    $nominal_bayar = $principal - $nom_admin - $nom_cadangan;

                                    $set('nominal_bayar', round($nominal_bayar, 2));
                                }
                            }
                        }),

                    TextInput::make('administrasi_rupiah')
                        ->label('Administrasi (Rp)')
                        ->numeric()
                        ->default(0)
                        ->required(fn ($get) => $get('jenis_administrasi') === 'rupiah') // Wajib jika rupiah dipilih
                        ->hidden(fn ($get) => $get('jenis_administrasi') !== 'rupiah') // Tersembunyi jika bukan rupiah
                        ->reactive()
                        ->afterStateUpdated(function (callable $set, $state, $get) {
                            if ($get('jenis_administrasi') === 'rupiah') {
                                $principal = $get('nominal_pinjaman');
                                $admin = $state;
                                $cadangan = $get('cadangan');

                                if ($principal && $admin ) {
                                    $nominal_bayar = $principal - $admin - ($principal * $cadangan / 100);

                                    $set('nominal_bayar', round($nominal_bayar, 2));
                                }
                            }
                        }),

                    TextInput::make('cadangan')
                        ->label('Cadangan (%)')
                        ->numeric()
                        ->default(0)
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function (callable $set, $state, $get) {
                            $principal = $get('nominal_pinjaman');
                            $admin = $get('jenis_administrasi') === 'persen'
                                ? $get('administrasi_persen')
                                : $get('administrasi_rupiah');
                            $cadangan = $state;

                            if ($principal && $admin ) {
                                $nominal_bayar = $get('jenis_administrasi') === 'persen'
                                    ? $principal - ($principal * $admin / 100) - ($principal * $cadangan / 100)
                                    : $principal - $admin - ($principal * $cadangan / 100);

                                $set('nominal_bayar', round($nominal_bayar, 2));
                            }
                        }),

                    TextInput::make('nominal_bayar')
                        ->label('Nominal Dibayarkan')
                        ->numeric()
                        ->readOnly()
                        ->default(0)
                        ->helperText('Kalkulasi Otomatis')
                        ->reactive(),

                ]),
            ])
            ->model(Kredit::class)
            ->statePath('data');
    }


    public function formSimpananWajib(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(4)->schema([TextInput::make('nominal')->numeric()->required(), DatePicker::make('tanggal')->required(), Select::make('d_k')->label('Stor/Tarik')->options(['Debet' => 'Stor', 'Kredit' => 'Tarik'])->required(), TextInput::make('deskripsi'), ]),

            ])
            ->model(SimpananWajibAnggota::class)->statePath('data');
    }

    public function formSimpananSukarela(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(4)->schema([TextInput::make('nominal')->numeric()->required(), DatePicker::make('tanggal')->required(), Select::make('d_k')->label('Stor/Tarik')->options(['Debet' => 'Stor', 'Kredit' => 'Tarik'])->required(), TextInput::make('deskripsi'), ]),

            ])
            ->model(SimpananSukarelaAnggota::class)->statePath('data');
    }

    public function formSimpananSukarelaJasa(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)->schema([
                    DatePicker::make('tanggal_akhir')->required()->label('Tanggal Akhir Bulan')->reactive()->afterStateUpdated(function (callable $set, $state, $get) {
                        // Ambil data input dari form
                        $tgl_akhir = $get('tanggal_akhir');  // Pinjaman Pokok
                        // $tgl_awal = date('Y-m',strtotime($get('tanggal_akhir'))).'-01';  // Pinjaman Pokok

                        $simsuk = SimpananNonModalData::where('anggota_koperasi_id',$this->anggota_id)->where('menu_id',$this->menu_id)->whereDate('tanggal','<=',$tgl_akhir)->get();

                        $tot = 0;
                        foreach ($simsuk as $key => $value) {
                            # code...
                            if ($value->d_k == 'Debet') {
                                # code...
                                $tot += $value->nominal;
                            }else{
                                $tot -= $value->nominal;

                            }
                        }
                        $set('saldo_akhir', round($tot));
                    }),
                    TextInput::make('saldo_akhir')->label('Saldo Akhir')->numeric()->required()->readOnly()->reactive(),
                    TextInput::make('tingkat_bunga')->label('Tingkat Jasa Tahunan (%)')->numeric()->required()->reactive()->afterStateUpdated(function (callable $set, $state, $get) {
                        // Ambil data input dari form
                        $bunga = $get('tingkat_bunga');  // Pinjaman Pokok
                        $saldo_akhir = $get('saldo_akhir');  // Pinjaman Pokok

                        $hit_bunga = $saldo_akhir * ($bunga/100) * (1/12);


                        $set('nominal_jasa', round($hit_bunga) );
                    }),
                    TextInput::make('nominal_jasa')->label('Nominal Jasa')->readOnly()->reactive(),
             ]),

            ])
            ->model(SimpananSukarelaAnggota::class)->statePath('data');
    }


    public function formSimpananSukarelaAdmin(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)->schema([
                    DatePicker::make('tanggal_akhir')->required()->label('Tanggal Akhir Bulan'),

                    TextInput::make('nominal_admin')->label('Nominal Admin'),
             ]),

            ])
            ->model(SimpananSukarelaAnggota::class)->statePath('data');
    }

    public function submitKredit(){
        $data = $this->formKredit->getState();
        $tanggal = $data['tanggal'];
        $tanggalCarbon = Carbon::parse($tanggal);

        unset($data['jenis_administrasi']);
        $data['anggota_koperasi_id'] = $this->anggota_id;

        if ($this->kredit_id) {
            $simpok = Kredit::where('id', $this->kredit_id)->update($data);
            $simpok = Kredit::where('id', $this->kredit_id)->first();
            $k_id = $this->kredit_id;
        } else {
            $simpok = Kredit::create($data);
            $k_id = $simpok->id;
        }

        // Loan data from the form
        $principal = $data['nominal_pinjaman'];  // Principal amount
        $interest_rate = $data['interest_rate']; // Monthly interest rate
        $num_installments = $data['num_installments'];  // Number of installments

        // Calculate the monthly installment (Angsuran/Bulan)
        $monthly_interest = $interest_rate / 100 * $principal;
        $total_installment = ($principal / $num_installments) + $monthly_interest;

        // Save the calculated monthly installment
        $simpok->angsuran_bulan = $total_installment;
        $simpok->save();

        // Loop through each installment and create KreditAngsuran entries (if needed)
        for ($i = 1; $i <= $num_installments; $i++) {
            KreditAngsuran::create([
                'angsuran_ke' => $i,
                'nominal_pokok' => $principal / $num_installments,
                'nominal_bunga' => $monthly_interest,
                'jumlah_angsuran' => $total_installment,
                'baki_debet' => $principal - ($i * ($principal / $num_installments)),
                'kredit_id' => $k_id,
                'tanggal_jatuh_tempo' => $tanggalCarbon->addMonths($i),  // Set the due date
            ]);
        }

        $controller = new Controller();
        $controller->jurnal_umum('Pinjam', $data['nominal_pinjaman'], $this->anggota_id, null, null, $simpok->created_at);

        // Reset form
        $this->kredit_id = null;
        $this->formHeader->fill();
        $this->formSimpananPokok->fill();
        $this->formSimpananWajib->fill();
        $this->formSimpananSukarela->fill();
        $this->formSimpananLainnya->fill();

        $this->formSimpananSukarelaJasa->fill();
        $this->formKredit->fill();

        return Notification::make()->title('Berhasil disubmit!')->success()->send();
    }

    public function goBayarAngsuranPokok($id)
    {
        $kredit_angsuran = KreditAngsuran::where('id', $id)->first();
        $kredit = Kredit::where('id',$kredit_angsuran->kredit_id)->first();
        $controller = new Controller();
        $controller->jurnal_umum('Bayar Pinjaman Pokok', $kredit_angsuran->nominal_pokok, $kredit->anggota_koperasi_id, null, null, $kredit_angsuran->tanggal_jatuh_tempo);
        // Mark the principal installment (Angsuran Pokok) as paid
        KreditAngsuran::where('id', $id)->update(['status_pokok' => 'Lunas']);

        // Add notification or any additional logic
        Notification::make()->title('Angsuran Pokok berhasil dilunasi!')->success()->send();
    }

    public function goBayarAngsuranJasa($id)
    {
        $kredit_angsuran = KreditAngsuran::where('id', $id)->first();
        $kredit = Kredit::where('id',$kredit_angsuran->kredit_id)->first();
        $controller = new Controller();
        $controller->jurnal_umum('Bayar Pinjaman Jasa', $kredit_angsuran->nominal_bunga, $kredit->anggota_koperasi_id, null, null, $kredit_angsuran->tanggal_jatuh_tempo);
        // Mark the interest installment (Angsuran Bunga) as paid
        KreditAngsuran::where('id', $id)->update(['status_bunga' => 'Lunas']);

        // Add notification or any additional logic
        Notification::make()->title('Angsuran Bunga berhasil dilunasi!')->success()->send();
    }



    public function submitSimpananPokok(){
        $data = $this->formSimpananPokok->getState();
        $data['anggota_koperasi_id'] = $this->anggota_id;

        if ($this->simpok_id) {
            # code...

            // prevent update tanggal
            unset($data['tanggal']);

            $simpok = SimpananPokokAnggota::where('id',$this->simpok_id)->update($data);
            $simpok = SimpananPokokAnggota::where('id',$this->simpok_id)->first();

        }else{

            $cek = SimpananPokokAnggota::where('anggota_koperasi_id',$this->anggota_id)->latest()->first();
            if (@$cek->tanggal > $data['tanggal']) {
                # code...
                return Notification::make()->title('Gagal disubmit, tanggal tidak boleh kurang dari transaksi terakhir!')->danger()->send();
            }
            $simpok = SimpananPokokAnggota::create($data);

        }

        $controller = new Controller();
        if ($data['d_k'] == 'Debet') {
            # code...
            $controller->jurnal_umum('Bayar Simpanan Pokok',$data['nominal'],$this->anggota_id,null,null,$simpok->created_at);

        }else{
            $controller->jurnal_umum('Bayar Simpanan Pokok Tarik',$data['nominal'],$this->anggota_id,null,null,$simpok->created_at);

        }

        $this->simpok_id = null;
        $this->simwa_id = null;
        $this->simsem_id = null;
        $this->formHeader->fill();
        $this->formSimpananPokok->fill();
        $this->formSimpananWajib->fill();
        $this->formSimpananLainnya->fill();

        $this->formSimpananSukarela->fill();
        $this->formSimpananSukarelaJasa->fill();
        return Notification::make()->title('Berhasil disubmit!')->success()->send();

    }

    public function submitSimpananLainnya(){
        $data = $this->formSimpananLainnya->getState();
        $data['anggota_koperasi_id'] = $this->anggota_id;

        if ($this->simla_id) {
            # code...

            // prevent update tanggal
            unset($data['tanggal']);

            $simpok = SimpananLainnyaAnggota::where('id',$this->simla_id)->update($data);
            $simpok = SimpananLainnyaAnggota::where('id',$this->simla_id)->first();

        }else{

            $cek = SimpananLainnyaAnggota::where('anggota_koperasi_id',$this->anggota_id)->latest()->first();
            if (@$cek->tanggal > $data['tanggal']) {
                # code...
                return Notification::make()->title('Gagal disubmit, tanggal tidak boleh kurang dari transaksi terakhir!')->danger()->send();
            }
            $simpok = SimpananLainnyaAnggota::create($data);

        }

        $controller = new Controller();
        if ($data['d_k'] == 'Debet') {
            # code...
            $controller->jurnal_umum('Bayar Simpanan Lainnya',$data['nominal'],$this->anggota_id,null,null,$simpok->created_at);

        }else{
            $controller->jurnal_umum('Bayar Simpanan Lainnya Tarik',$data['nominal'],$this->anggota_id,null,null,$simpok->created_at);

        }

        $this->simla_id = null;
        $this->simwa_id = null;
        $this->simsem_id = null;
        $this->formHeader->fill();
        $this->formSimpananPokok->fill();
        $this->formSimpananWajib->fill();
        $this->formSimpananLainnya->fill();

        $this->formSimpananSukarela->fill();
        $this->formSimpananSukarelaJasa->fill();
        return Notification::make()->title('Berhasil disubmit!')->success()->send();

    }

    public function goUbahItemKredit($id){
        if (KreditAngsuran::where('kredit_id',$id)->where('status','Lunas')->first()) {
            # code...
            return Notification::make()->title('Gagal diubah!, angsuran sedang berjalan')->danger()->send();

        }
        $this->kredit_id = $id;
        $simpok = Kredit::where('id',$id)->first();

        $this->formKredit->fill($simpok->toArray());

    }

    public function goUbahItemSimpananPokok($id){
        $this->simpok_id = $id;
        $simpok = SimpananPokokAnggota::where('id',$id)->first();

        $this->formSimpananPokok->fill($simpok->toArray());

    }

    public function goUbahItemSimpananLainnya($id){
        $this->simla_id = $id;
        $simpok = SimpananLainnyaAnggota::where('id',$id)->first();

        $this->formSimpananLainnya->fill($simpok->toArray());

    }

    public function goHapusItemKredit($id){
        if (KreditAngsuran::where('kredit_id',$id)->where('status','Lunas')->first()) {
            # code...
            return Notification::make()->title('Gagal dihapus!, angsuran sedang berjalan')->danger()->send();

        }

        $simpok = KreditAngsuran::where('kredit_id',$id)->delete();
        $simpok = Kredit::where('id',$id)->first();

        $controller = new Controller();
        $controller->jurnal_umum('Pinjam', $simpok->nominal_pinjaman,$simpok->anggota_koperasi_id,null,null,$simpok->created_at,true);

        $simpok->delete();
        return Notification::make()->title('Berhasil dihapus!')->success()->send();

    }

    public function goHapusItemSimpananPokok($id){
        $simpok = SimpananPokokAnggota::where('id',$id)->first();

        $controller = new Controller();
        $controller->jurnal_umum('Bayar Simpanan Pokok',$simpok->nominal,$simpok->anggota_koperasi_id,null,null,$simpok->created_at,true);

        $simpok->delete();
        return Notification::make()->title('Berhasil dihapus!')->success()->send();

    }

    public function goHapusItemSimpananLainnya($id){
        $simpok = SimpananLainnyaAnggota::where('id',$id)->first();

        $controller = new Controller();
        $controller->jurnal_umum('Bayar Simpanan Lainnya',$simpok->nominal,$simpok->anggota_koperasi_id,null,null,$simpok->created_at,true);

        $simpok->delete();
        return Notification::make()->title('Berhasil dihapus!')->success()->send();

    }

    public function submitSimpananWajib(){
        $data = $this->formSimpananWajib->getState();
        $data['anggota_koperasi_id'] = $this->anggota_id;

        if ($this->simwa_id) {
            # code...
            unset($data['tanggal']);

            $simpok = SimpananWajibAnggota::where('id',$this->simwa_id)->update($data);
            $simpok = SimpananWajibAnggota::where('id',$this->simwa_id)->first();

        }else{
            $cek = SimpananWajibAnggota::where('anggota_koperasi_id',$this->anggota_id)->latest()->first();
            if (@$cek->tanggal > $data['tanggal']) {
                # code...
                return Notification::make()->title('Gagal disubmit, tanggal tidak boleh kurang dari transaksi terakhir!')->danger()->send();
            }
            $simpok = SimpananWajibAnggota::create($data);

        }

        $controller = new Controller();
        if ($data['d_k'] == 'Debet') {
            $controller->jurnal_umum('Bayar Simpanan Wajib',$data['nominal'],$this->anggota_id,null,null,$simpok->created_at);
        }else{
            $controller->jurnal_umum('Bayar Simpanan Wajib Tarik',$data['nominal'],$this->anggota_id,null,null,$simpok->created_at);

        }

        $this->simpok_id = null;
        $this->simwa_id = null;
        $this->simsem_id = null;
        $this->formHeader->fill();
        $this->formSimpananPokok->fill();
        $this->formSimpananWajib->fill();
        $this->formSimpananSukarela->fill();
        $this->formSimpananLainnya->fill();

        $this->formSimpananSukarelaJasa->fill();

        return Notification::make()->title('Berhasil disubmit!')->success()->send();

    }

    public function goUbahItemSimpananWajib($id){
        $this->simwa_id = $id;
        $simpok = SimpananWajibAnggota::where('id',$id)->first();

        $this->formSimpananWajib->fill($simpok->toArray());

    }

    public function goHapusItemSimpananWajib($id){
        $simpok = SimpananWajibAnggota::where('id',$id)->first();

        $controller = new Controller();
        $controller->jurnal_umum('Bayar Simpanan Wajib',$simpok->nominal,$simpok->anggota_koperasi_id,null,null,$simpok->created_at,true);

        $simpok->delete();
        return Notification::make()->title('Berhasil dihapus!')->success()->send();

    }


    public function submitSimpananSukarela(){
        $data = $this->formSimpananSukarela->getState();
        $data['anggota_koperasi_id'] = $this->anggota_id;

        if ($this->simsem_id) {
            # code...
            $simpok = SimpananSukarelaAnggota::where('id',$this->simsem_id)->update($data);
            $simpok = SimpananSukarelaAnggota::where('id',$this->simsem_id)->first();

        }else{
            $simpok = SimpananSukarelaAnggota::create($data);

        }

        $controller = new Controller();
        if ($data['d_k'] == 'Debet') {

            $controller->jurnal_umum('Bayar Setoran Sukarela',$data['nominal'],$this->anggota_id,null,null,$simpok->created_at);
        }else{
            $controller->jurnal_umum('Bayar Setoran Sukarela Tarik',$data['nominal'],$this->anggota_id,null,null,$simpok->created_at);

        }
        $this->simpok_id = null;
        $this->simwa_id = null;
        $this->simsem_id = null;
        $this->formHeader->fill();
        $this->formSimpananPokok->fill();
        $this->formSimpananWajib->fill();
        $this->formSimpananSukarela->fill();
        $this->formSimpananLainnya->fill();

        $this->formSimpananSukarelaJasa->fill();

        return Notification::make()->title('Berhasil disubmit!')->success()->send();

    }

    public function goUbahItemSimpananSukarela($id){
        $this->simsem_id = $id;
        $simpok = SimpananNonModalData::where('id',$id)->first();

        $this->formSimpananSukarela->fill($simpok->toArray());

    }

    public function goHapusItemSimpananSukarela($id){
        $simpok = SimpananSukarelaAnggota::where('id',$id)->first();

        $controller = new Controller();
        $controller->jurnal_umum('Bayar Simpanan Non Modal',$simpok->nominal,$simpok->anggota_koperasi_id,null,null,$simpok->created_at,true);

        $simpok->delete();
        return Notification::make()->title('Berhasil dihapus!')->success()->send();

    }

    public function goBayarItemKreditAngsuran($id){
        KreditAngsuran::where('id',$id)->update([
            'status' => "Lunas",
            'tgl' => date('Y-m-d')
        ]);

        return Notification::make()->title('Berhasil dibayar!')->success()->send();

    }

    public $index_open_kredit = [];
    public function goToggleShowKredit($id)
    {
        $key = array_search($id, $this->index_open_kredit);
        if ($key !== false) {
            unset($this->index_open_kredit[$key]);
        } else {
            $this->index_open_kredit[] = $id;
        }
    }

    public function updateAngsuran($id, $field)
    {
        $value = $this->angsuran[$id][$field] ?? null;

        if ($value !== null) {
            // Lakukan penyimpanan ke database
            KreditAngsuran::where('id', $id)->update([$field => $value]);

            // Flash message atau notifikasi jika diperlukan
            return Notification::make()->title('Data berhasil diupdate!')->success()->send();
        }
    }

    public function buatHutangBaru($utang){
        $this->formKredit->fill([
            'nominal_pinjaman' => $utang
        ]);
    }

    public function render()
    {
        $data['simpanan_pokok'] = SimpananPokokAnggota::where('anggota_koperasi_id',$this->anggota_id)->get();
        $data['simpanan_lainnya'] = SimpananLainnyaAnggota::where('anggota_koperasi_id',$this->anggota_id)->get();
        $data['simpanan_wajib'] = SimpananWajibAnggota::where('anggota_koperasi_id',$this->anggota_id)->get();
        $data['simpanan_sukarela'] = SimpananNonModalData::where('anggota_koperasi_id',$this->anggota_id)->where('menu_id',$this->menu_id)->get();
        $data['kredit'] = Kredit::with('kredit_angsuran')->where('anggota_koperasi_id',$this->anggota_id)->where('kredit','Flat')->get();
        $data['kredit_konvensional'] = KreditKonvensional::with('kredit_konvensional_angsuran')->where('anggota_koperasi_id',$this->anggota_id)->get();
        foreach ($data['kredit'] as $key => $value) {
            # code...
            foreach ($value['kredit_angsuran'] as $key2 => $value2) {
                # code...
                // $this->angsuran[$value2['id']] = $value2;
            }
        }
        $data['identitas_koperasi'] = IdentitasKoperasi::where('id',$this->anggota->identitas_koperasi_id)->first();

        // hitung
        $porto = [];

        $lunas = 0;
        $belum_lunas = 0;
        foreach ($data['kredit'] as $key => $value) {
            # code...
            foreach ($value->kredit_angsuran as $key2 => $value2) {
                # code...
                if ($value2->status_pokok == 'Belum Lunas') {
                    # code...
                    $belum_lunas += $value2->nominal_pokok;
                }

                if ($value2->status_bunga == 'Belum Lunas') {
                    # code...
                    $belum_lunas += $value2->nominal_bunga;
                }

                if ($value2->status_pokok == 'Lunas') {
                    # code...
                    $lunas += $value2->nominal_pokok;
                }

                if ($value2->status_bunga == 'Lunas') {
                    # code...
                    $lunas += $value2->nominal_bunga;
                }


            }
        }

        $porto ['Kredit Flat Belum Lunas'] = $belum_lunas;
        $porto ['Kredit Flat Lunas'] = $lunas;

        $lunas = 0;
        $belum_lunas = 0;
        foreach ($data['kredit_konvensional'] as $key => $value) {
            # code...
            foreach ($value->kredit_konvensional_angsuran as $key2 => $value2) {
                # code...
                if ($value2->status_pokok == 'Belum Lunas') {
                    # code...
                    $belum_lunas += $value2->angsuran_pokok;

                }

                if ($value2->status_bunga == 'Belum Lunas') {
                    # code...
                    $belum_lunas += $value2->angsuran_bunga;
                    continue;
                }

                if ($value2->status_pokok == 'Lunas') {
                    # code...
                    $lunas += $value2->angsuran_pokok;

                }

                if ($value2->status_bunga == 'Lunas') {
                    # code...
                    $lunas += $value2->angsuran_bunga;
                    continue;
                }
            }
        }
        $porto ['Kredit Konvensional Belum Lunas'] = $belum_lunas;
        $porto ['Kredit Konvensional Lunas'] = $lunas;

        $total = 0;
        foreach ($data['simpanan_pokok'] as $key => $value) {
            # code...
            if ($value['d_k'] == 'Debet') {
                $total += $value['nominal'];
            }

            if ($value['d_k'] == 'Kredit') {
                $total -= $value['nominal'];
            }

        }

        $porto ['Simpanan Pokok'] = $total;

        $total = 0;
        foreach ($data['simpanan_wajib'] as $key => $value) {
            # code...
            if ($value['d_k'] == 'Debet') {
                $total += $value['nominal'];
            }

            if ($value['d_k'] == 'Kredit') {
                $total -= $value['nominal'];
            }

        }

        $porto ['Simpanan Wajib'] = $total;

        $total = 0;
        foreach ($data['simpanan_lainnya'] as $key => $value) {
            # code...
            if ($value['d_k'] == 'Debet') {
                $total += $value['nominal'];
            }

            if ($value['d_k'] == 'Kredit') {
                $total -= $value['nominal'];
            }

        }

        $porto ['Simpanan Lainnya'] = $total;


        $sim_non = SimpananNonModalData::with('simpanan_non_modal_menu')->where('anggota_koperasi_id',$this->anggota_id)->get()->groupBy('menu_id');

        foreach ($sim_non as $key2 => $value2) {
            # code...
            $total = 0;
            $menu_id = 0;
            foreach ($value2 as $key => $value) {
                # code...
                if ($value['d_k'] == 'Debet') {
                    $total += $value['nominal'];
                }

                if ($value['d_k'] == 'Kredit') {
                    $total -= $value['nominal'];
                }

                $menu_id = $value->menu_id;
            }
            $porto [$value->simpanan_non_modal_menu->nama_menu] = $total;

        }

        $data['porto'] = $porto;

        return view('livewire.anggota-koperasi-detail',$data);
    }
}
