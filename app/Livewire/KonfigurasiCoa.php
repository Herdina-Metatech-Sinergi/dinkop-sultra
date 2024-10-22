<?php

namespace App\Livewire;

use App\Models\KonfigurasiCoa as ModelsKonfigurasiCoa;
use App\Models\MasterCoa;
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

class KonfigurasiCoa extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public $entries = [];
    public $nama;
    public $keterangan;
    public $total_debet = 0;
    public $total_kredit = 0;
    public $perbedaan = 0;
    public $konfigurasi;

    public function mount(): void
    {
        $this->form->fill();
        $this->entries = [['id' => null, 'akun' => null, 'deskripsi' => '', 'dk' => null, 'nominal' => '']];
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

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)
                    ->schema([


                        TextInput::make('nama')
                            ->label('Nama Konfigurasi COA')
                            ->required(),
                        TextInput::make('keterangan')
                            ->label('Keterangan'),
                    ]),

                Grid::make(1)
                    ->schema([
                Repeater::make('entries')
                    ->label('')
                    ->schema([
                        TextInput::make('id')
                            ->label('ID')
                            ->readOnly(),

                        Select::make('akun')
                            ->label('Pilih Akun')
                            ->searchable()
                            // ->relationship('master_coa','title')
                            ->options(MasterCoa::all()->pluck('title', 'kode_coa'))

                            ->required()
                            ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                $akun_id = $state;

                                $msc = MasterCoa::where('kode_coa',$akun_id)->first();
                                $set('dk',strtolower($msc->saldo_normal)) ;
                            })->reactive(),



                        Select::make('dk')
                            ->label('D/K')
                            ->options([
                                'debet' => 'Debet',
                                'kredit' => 'Kredit',
                            ])
                            ->required()->reactive(),

                        TextInput::make('nominal')
                            ->label('Nominal (Untuk simulasi)')
                            ->numeric()
                            ->required(),
                    ])
                    ->columns(4)
                    ->defaultItems(1)
                    ->createItemButtonLabel('Tambah Data')
                    ->reactive()  // Penting untuk perhitungan live
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
            ->model(ModelsKonfigurasiCoa::class);
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

        // dd($this->form->getState());
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

        $entries = $this->form->getState()['entries'];

        $totalDebet = 0;
        $totalKredit = 0;

        foreach ($entries as $entry) {
            if ($entry['dk'] === 'debet') {
                $totalDebet += $entry['nominal'];
            } else {
                $totalKredit += $entry['nominal'];
            }
        }

        $this->form->fill([
            'total_debet' => $totalDebet,
            'total_kredit' => $totalKredit,
            'perbedaan' => abs($totalDebet - $totalKredit),
        ]);

        if ($totalDebet !== $totalKredit) {
            // $this->notify('danger', 'Total Debet dan Kredit harus seimbang!');
            return Notification::make()->title('Total Debet dan Kredit harus seimbang!')->danger()->send();
        }

        // ini untuk edit data
        if($this->konfigurasi){
            foreach ($this->form->getState()['entries'] as $key => $value) {
                # code...
                ModelsKonfigurasiCoa::where(['nama' => $this->konfigurasi,'id' => $value['id']])->update([
                    // 'persen' => $value['persen'],
                    'akun' => $value['akun'],
                    'd_k' => $value['dk'],
                    'keterangan' => $this->form->getState()['keterangan'],
                    'nama' => $this->form->getState()['nama'],
                ]);
            }
        }else{
            foreach ($this->form->getState()['entries'] as $key => $value) {
                # code...
                ModelsKonfigurasiCoa::create([
                    // 'persen' => $value['persen'],
                    'akun' => $value['akun'],
                    'd_k' => $value['dk'],
                    'keterangan' => $this->form->getState()['keterangan'],
                    'nama' => $this->form->getState()['nama'],
                ]);
            }
        }


        $this->reset();
        return Notification::make()->title('Berhasil submit konfigurasi umum!')->success()->send();
    }

    public function delete(ModelsKonfigurasiCoa $konfigurasi){
        $konfigurasi = ModelsKonfigurasiCoa::where('nama',$konfigurasi->nama)->delete();
        return Notification::make()->title('Berhasil hapus konfigurasi umum!')->success()->send();

    }

    public function edit(ModelsKonfigurasiCoa $konfigurasi): void
    {
        $this->konfigurasi = $konfigurasi->nama;
        $konfigurasi = ModelsKonfigurasiCoa::where('nama',$konfigurasi->nama)->get();

        $entries = [];
        foreach ($konfigurasi as $key => $value) {
            # code...
            $entries [] = [
                'id' => $value->id,
                'akun' => $value->akun,
                'deskripsi' => $value->deskripsi,
                'dk' => $value->d_k,
                'nominal' => $value->nominal ?? 0,
            ];
        }

        $jurn = $konfigurasi[0];
        // Isi form dengan data konfigurasi yang dipilih
        $this->form->fill([
            'nama' => $jurn->nama,
            'keterangan' => $jurn->keterangan,
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

        // dd($this->form->getState());
        // dd($totalDebet);
        $this->total_debet = $totalDebet;
        $this->total_kredit = $totalKredit;
        $this->perbedaan = abs($totalDebet - $totalKredit);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(ModelsKonfigurasiCoa::query())
            ->columns([TextColumn::make('nama')->searchable(), TextColumn::make('keterangan')->searchable(), TextColumn::make('d_k')->searchable(), TextColumn::make('akun')->searchable(), ])
            ->filters([
                // ...
            ])
            ->actions([
                // ...
                Action::make('edit')->label('Ubah')->action(fn(ModelsKonfigurasiCoa $record) => $this->edit($record)),

Action::make('delete')
    ->label('Hapus')
    ->action(fn (ModelsKonfigurasiCoa $record) => $this->delete($record))
    ->requiresConfirmation()
    ->modalHeading('Konfirmasi Penghapusan')
    ->modalSubheading('Apakah Anda yakin ingin menghapus konfigurasi ini?')
    ->modalButton('Hapus')
    ->icon('heroicon-o-trash')
    ->color('danger'),

            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.konfigurasi-coa');
    }
}
