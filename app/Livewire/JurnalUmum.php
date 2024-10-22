<?php

namespace App\Livewire;

use App\Models\IdentitasKoperasi;
use App\Models\JurnalUmum as ModelsJurnalUmum;
use App\Models\MasterCoa;
use App\Models\User;
use Carbon\Carbon;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class JurnalUmum extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public $entries = [];
    public $identitas_koperasi_id;
    public $user_id;
    public $tanggal;
    public $total_debet = 0;
    public $total_kredit = 0;
    public $perbedaan = 0;
    public $jurnal;
    public $filters = [
        'tgl_awal' => null,
        'tgl_akhir' => null,
        'identitas_koperasi_id' => null,
    ];

    public function mount(): void
    {
        $this->createForm->fill();
        $this->entries = [['id' => null, 'akun' => null, 'deskripsi' => '', 'dk' => null, 'nominal' => '']];

        if (auth()->user()->hasRole('Admin Dinkop')) {
            $firstOption = IdentitasKoperasi::get()->pluck('id')->first();
        } else {
            $firstOption = IdentitasKoperasi::where('user_id', auth()->user()->id)
                                            ->pluck('id')
                                            ->first();
        }

        $this->filters['identitas_koperasi_id']  = $firstOption;
        $this->filters['tgl_awal']  = date('Y-m').'-01';
        $this->filters['tgl_akhir']  = date('Y-m-d');
    }

    public function updated($field)
    {
        if ($field === 'entries') {
            $this->calculateTotals($this->entries, function ($key, $value) {
                $this->{$key} = $value;
            });
        }
    }

    public function updatedEntries($value)
    {
        $this->calculateTotals($this->entries, function ($key, $value) {
            $this->{$key} = $value;
        });
    }


    public function getFilterFormSchema(Form $form): Form
    {
        return $form
            ->schema([Grid::make(3)->schema([
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
                })->searchable()->required()->label('Identitas Koperasi'),
                    TextInput::make('filters.tgl_awal')->lazy()
                        ->required()
                        ->type('date'),
                    TextInput::make('filters.tgl_akhir')->lazy()
                        ->required()
                        ->type('date'),

            ])])->model(ModelsJurnalUmum::class);
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

    public function exportPDF()
    {
        try {
            $this->formValidation();

            $tgl_awal = Carbon::parse($this->filters['tgl_awal']);
            $tgl_akhir = Carbon::parse($this->filters['tgl_akhir']);


            $_url = '/admin/cetak/jurnal-umum?tgl_awal=' . $tgl_awal->toDateString() . '&tgl_akhir=' . $tgl_akhir->toDateString() . '&identitas_koperasi_id=' . $this->filters['identitas_koperasi_id'];
            return redirect($_url);
            // $this->dispatch('download-export', $_url);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    protected function getForms(): array
    {
        return [
            'getFilterFormSchema',
            'createForm',
        ];
    }

    public function createForm(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)->schema([Select::make('identitas_koperasi_id')->options(function () {
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
                })->searchable()->required()->label('Identitas Koperasi'), Select::make('user_id')->label('Pengguna')->options(function () {
                    // Cek apakah user memiliki role "Admin"
                    if (auth()->user()->hasRole('Admin')) {
                        // Jika user adalah Admin, tampilkan semua opsi
                        return User::get()->pluck('name', 'id');
                    } else {
                        // Jika bukan Admin, tampilkan opsi yang sesuai dengan kondisi tertentu
                        return User::where('id', auth()->user()->id)
                                                ->pluck('name', 'id');
                    }
                })->default(auth()->user()->id)->required()->searchable(), DatePicker::make('tanggal')->label('Tanggal')->required()]),

                Grid::make(1)->schema([
                    Repeater::make('entries')
                        ->label('')
                        ->schema([
                            TextInput::make('id')->label('ID')->readOnly(),

                            Select::make('akun')
                                ->label('Pilih Akun')
                                ->searchable()
                                // ->relationship('master_coa','title')
                                ->options(MasterCoa::whereRaw('LENGTH(kode_coa) >= 4')->get()->pluck('title', 'kode_coa'))
                                ->required()
                                ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                    $akun_id = $state;

                                    $msc = MasterCoa::where('kode_coa',$akun_id)->first();
                                    $set('dk',strtolower($msc->saldo_normal)) ;
                                })->reactive(),

                            TextInput::make('deskripsi')->label('Deskripsi')->required(),

                            Select::make('dk')
                                ->label('D/K')
                                ->options([
                                    'debet' => 'Debet',
                                    'kredit' => 'Kredit',
                                ])
                                ->required()->reactive(),

                            TextInput::make('nominal')->label('Nominal')->numeric()->required(),
                        ])
                        ->columns(5)
                        ->defaultItems(1)
                        ->createItemButtonLabel('Tambah Data')
                        ->reactive() // Ensure reactivity
                        ->afterStateUpdated(function ($state, callable $set) {
                            $this->calculateTotals($state, $set); // Recalculate totals after the state is updated
                        }),
                ]),

                Grid::make(1)->schema([
                    TextInput::make('total_debet')->label('Total Debet')->readOnly(),

                    TextInput::make('total_kredit')->label('Total Kredit')->readOnly(),

                    TextInput::make('perbedaan')
                        ->label('Perbedaan')
                        ->readOnly()
                        ->extraAttributes(['class' => 'text-red-600']),
                ]),
            ])
            ->model(ModelsJurnalUmum::class);
    }

    protected function calculateTotals(array $entries, callable $set): void
    {
        $totalDebet = 0;
        $totalKredit = 0;

        foreach ($entries as $entry) {
            // Ensure 'dk' and 'nominal' are set and valid
            if (!empty($entry['dk']) && isset($entry['nominal']) && is_numeric($entry['nominal'])) {
                $nominal = (float) $entry['nominal'];

                if ($entry['dk'] === 'debet') {
                    $totalDebet += $nominal;
                } elseif ($entry['dk'] === 'kredit') {
                    $totalKredit += $nominal;
                }
            }
        }

        // dd($this->createForm->getState());
        // dd($totalDebet);
        $this->total_debet = $totalDebet;
        $this->total_kredit = $totalKredit;
        $this->perbedaan = abs($totalDebet - $totalKredit);
        // Set the totals using the callable $set
        $set('total_debet', $totalDebet);
        $set('total_kredit', $totalKredit);

        // Calculate the difference between debet and kredit
        $set('perbedaan', abs($totalDebet - $totalKredit));
    }

    public function submit()
    {
        // cek seimbang

        $entries = $this->createForm->getState()['entries'];

        $totalDebet = 0;
        $totalKredit = 0;

        foreach ($entries as $entry) {
            if ($entry['dk'] === 'debet') {
                $totalDebet += $entry['nominal'];
            } else {
                $totalKredit += $entry['nominal'];
            }
        }

        $this->createForm->fill([
            'total_debet' => $totalDebet,
            'total_kredit' => $totalKredit,
            'perbedaan' => abs($totalDebet - $totalKredit),
        ]);

        if ($totalDebet !== $totalKredit) {
            // $this->notify('danger', 'Total Debet dan Kredit harus seimbang!');
            return Notification::make()->title('Total Debet dan Kredit harus seimbang!')->danger()->send();
        }

        // ini untuk edit data
        if ($this->jurnal) {
            foreach ($this->createForm->getState()['entries'] as $key => $value) {
                # code...
                ModelsJurnalUmum::where(['jurnal' => $this->jurnal, 'id' => $value['id']])->update([
                    'tanggal' => $this->createForm->getState()['tanggal'],
                    'deskripsi' => $value['deskripsi'],
                    'akun' => $value['akun'],
                    'd_k' => $value['dk'],
                    'nominal' => $value['nominal'],
                    'identitas_koperasi_id' => $this->createForm->getState()['identitas_koperasi_id'],
                    'user_id' => $this->createForm->getState()['user_id'],
                ]);
            }
        } else {
            $jurnal = date('Ymd', strtotime($this->createForm->getState()['tanggal'])) . date('His') . '#' . $this->createForm->getState()['identitas_koperasi_id'] . '#' . $this->createForm->getState()['user_id'];
            foreach ($this->createForm->getState()['entries'] as $key => $value) {
                # code...
                ModelsJurnalUmum::create([
                    'tanggal' => $this->createForm->getState()['tanggal'],
                    'jurnal' => $jurnal, // You can customize the journal number
                    'deskripsi' => $value['deskripsi'],
                    'akun' => $value['akun'],
                    'd_k' => $value['dk'],
                    'nominal' => $value['nominal'],
                    'identitas_koperasi_id' => $this->createForm->getState()['identitas_koperasi_id'],
                    'user_id' => $this->createForm->getState()['user_id'],
                ]);
            }
        }

        $this->reset();
        return Notification::make()->title('Berhasil submit jurnal umum!')->success()->send();
    }

    public function delete(ModelsJurnalUmum $jurnal)
    {
        $jurnal = ModelsJurnalUmum::where('jurnal', $jurnal->jurnal)->delete();
        return Notification::make()->title('Berhasil hapus jurnal umum!')->success()->send();
    }

    public function edit(ModelsJurnalUmum $jurnal): void
    {
        $this->jurnal = $jurnal->jurnal;
        $jurnal = ModelsJurnalUmum::where('jurnal', $jurnal->jurnal)->get();

        $entries = [];
        foreach ($jurnal as $key => $value) {
            # code...
            $entries[] = [
                'id' => $value->id,
                'akun' => $value->akun,
                'deskripsi' => $value->deskripsi,
                'dk' => $value->d_k,
                'nominal' => $value->nominal,
            ];
        }

        $jurn = $jurnal[0];
        // Isi form dengan data jurnal yang dipilih
        $this->createForm->fill([
            'identitas_koperasi_id' => $jurn->identitas_koperasi_id,
            'user_id' => $jurn->user_id,
            'tanggal' => $jurn->tanggal,
            'entries' => $entries,
        ]);

        $totalDebet = 0;
        $totalKredit = 0;

        foreach ($entries as $entry) {
            // Ensure 'dk' and 'nominal' are set and valid
            if (!empty($entry['dk']) && isset($entry['nominal']) && is_numeric($entry['nominal'])) {
                $nominal = (float) $entry['nominal'];

                if ($entry['dk'] === 'debet') {
                    $totalDebet += $nominal;
                } elseif ($entry['dk'] === 'kredit') {
                    $totalKredit += $nominal;
                }
            }
        }

        // dd($this->createForm->getState());
        // dd($totalDebet);
        $this->total_debet = $totalDebet;
        $this->total_kredit = $totalKredit;
        $this->perbedaan = abs($totalDebet - $totalKredit);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(ModelsJurnalUmum::query())
            ->columns([TextColumn::make('jurnal')->searchable(), TextColumn::make('tanggal')->searchable(), TextColumn::make('d_k')->searchable(),TextColumn::make('akun')->searchable(), TextColumn::make('nominal')->searchable(), TextColumn::make('deskripsi')->searchable(), TextColumn::make('identitas_koperasi.nama_koperasi')->searchable(), TextColumn::make('user.name')->searchable()])
            ->filters([
                // ...
            ])
            ->actions([
                // ...
                Action::make('edit')->label('Ubah')->action(fn(ModelsJurnalUmum $record) => $this->edit($record)),

                Action::make('delete')->label('Hapus')->action(fn(ModelsJurnalUmum $record) => $this->delete($record))->requiresConfirmation()->modalHeading('Konfirmasi Penghapusan')->modalSubheading('Apakah Anda yakin ingin menghapus jurnal ini?')->modalButton('Hapus')->icon('heroicon-o-trash')->color('danger'),
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.jurnal-umum');
    }
}
