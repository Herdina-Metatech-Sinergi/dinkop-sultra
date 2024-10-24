<?php

namespace App\Livewire\AnggotaKoperasiDetail;

use App\Http\Controllers\Controller;
use App\Models\Kredit;
use App\Models\KreditAngsuran;
use App\Models\KreditKonvensional as ModelsKreditKonvensional;
use App\Models\KreditKonvensionalAngsuran;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Livewire\Component;

class KreditKonvensional extends Component implements HasForms
{
    use InteractsWithForms;

    public $anggota_id;
    public $kredit_id;
    public $index_open_kredit = [];
    public ?array $data = [];

    public function mount($anggota_id, $index_open_kredit){
        $this->anggota_id = $anggota_id;
        $this->index_open_kredit = $index_open_kredit;
        $this->formKreditKonvensional->fill([
            'kredit' => 'Konvensional',
            // 'pinjaman_pokok' => 40000000000,
            // 'jangka_waktu' => 60,
            // 'angsuran_pokok_berikutnya' => 666666000,
            // 'tanggal_mulai' => '2024-02-26',
            // 'tanggal_jatuh_tempo_pertama' => '2024-04-25',
        ]);

    }

    protected function getForms(): array
    {
        return [
            'formKreditKonvensional',
        ];
    }

    public function formKreditKonvensional(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)->schema([
                    TextInput::make('kredit')->readOnly()->label('Jenis Kredit')->default('Konvensional'),
                    TextInput::make('pinjaman_pokok')
                        ->label('Pinjaman Pokok')
                        ->numeric()
                        ->required()->afterStateUpdated(function (callable $set, $state, $get) {
                            // Ambil data input dari form
                            $principal = $get('pinjaman_pokok');  // Pinjaman Pokok
                            $interest_rate = $get('tarif_layanan'); // Suku Bunga (%)
                            $num_installments = $get('jangka_waktu'); // Jangka Waktu (bulan)

                            // Hitung angsuran per bulan
                            if ($principal && $interest_rate && $num_installments) {
                                // $monthly_interest = $interest_rate / 100 * $principal;
                                $total_installment = $principal / $num_installments;

                                // Simpan hasilnya ke angsuran_bulan
                                $set('angsuran_pokok_pertama', round($total_installment, 2));
                            }
                        })
                        ->reactive(),
                    TextInput::make('agunan')->label('Agunan')->helperText('Agunan 60% dari pokok pinjaman'),

                    TextInput::make('jangka_waktu')
                        ->label('Jangka Waktu (Bulan)')
                        ->numeric()
                        ->required()->afterStateUpdated(function (callable $set, $state, $get) {
                            // Ambil data input dari form
                            $principal = $get('pinjaman_pokok');  // Pinjaman Pokok
                            $interest_rate = $get('tarif_layanan'); // Suku Bunga (%)
                            $num_installments = $get('jangka_waktu'); // Jangka Waktu (bulan)

                            // Hitung angsuran per bulan
                            if ($principal && $interest_rate && $num_installments) {
                                // $monthly_interest = $interest_rate / 100 * $principal;
                                $total_installment = $principal / $num_installments;

                                // Simpan hasilnya ke angsuran_bulan
                                $set('angsuran_pokok_pertama', round($total_installment, 2));
                            }
                        })
                        ->reactive(),

                    TextInput::make('tarif_layanan')
                        ->label('Jasa Layanan (%)')
                        ->numeric()
                        ->required()->afterStateUpdated(function (callable $set, $state, $get) {
                            // Ambil data input dari form
                            $principal = $get('pinjaman_pokok');  // Pinjaman Pokok
                            $interest_rate = $get('tarif_layanan'); // Suku Bunga (%)
                            $num_installments = $get('jangka_waktu'); // Jangka Waktu (bulan)

                            // Hitung angsuran per bulan
                            if ($principal && $interest_rate && $num_installments) {
                                // $monthly_interest = $interest_rate / 100 * $principal;
                                $total_installment = $principal / $num_installments;

                                // Simpan hasilnya ke angsuran_bulan
                                $set('angsuran_pokok_pertama', round($total_installment, 2));
                            }
                        })
                        ->reactive(),

                    TextInput::make('angsuran_pokok_pertama')
                        ->label('Angsuran Pokok Pertama')
                        ->numeric()
                        ->helperText('Kalkulasi Otomatis')
                        ->readOnly()
                        ->reactive(),

                    TextInput::make('angsuran_pokok_berikutnya')
                        ->label('Angsuran Pokok Berikutnya')
                        ->numeric()
                        ->required(),

                    DatePicker::make('tanggal_mulai')
                        ->label('Tanggal Mulai')
                        ->required(),

                    DatePicker::make('tanggal_jatuh_tempo_pertama')
                        ->label('Tanggal Jatuh Tempo Pertama')
                        ->required(),
                ]),
                // Grid::make(5)->schema([
                //     // Principal Loan Amount (Pinjaman Pokok)
                //     TextInput::make('nominal_pinjaman')->numeric()->required()->label('Nominal Pinjaman Pokok')
                //     ->afterStateUpdated(function (callable $set, $state, $get) {
                //         // Ambil data input dari form
                //         $principal = $get('nominal_pinjaman');  // Pinjaman Pokok
                //         $interest_rate = $get('interest_rate'); // Suku Bunga (%)
                //         $num_installments = $get('num_installments'); // Jangka Waktu (bulan)

                //         // Hitung angsuran per bulan
                //         if ($principal && $interest_rate && $num_installments) {
                //             // $monthly_interest = $interest_rate / 100 * $principal;
                //             $total_installment = $principal / $num_installments;

                //             // Simpan hasilnya ke angsuran_bulan
                //             $set('angsuran_bulan', round($total_installment, 2));
                //         }
                //     })
                //     ->reactive(), // Reactive to trigger recalculation

                //     // Interest rate (Suku Bunga)
                //     TextInput::make('interest_rate')
                //         ->numeric()
                //         ->required()
                //         ->reactive() // Reactive to trigger recalculation
                //         ->afterStateUpdated(function (callable $set, $state, $get) {
                //             // Ambil data input dari form
                //             $principal = $get('nominal_pinjaman');  // Pinjaman Pokok
                //             $interest_rate = $get('interest_rate'); // Suku Bunga (%)
                //             $num_installments = $get('num_installments'); // Jangka Waktu (bulan)

                //             // Hitung angsuran per bulan
                //             if ($principal && $interest_rate && $num_installments) {
                //                 // $monthly_interest = $interest_rate / 100 * $principal;
                //                 $total_installment = $principal / $num_installments;

                //                 // Simpan hasilnya ke angsuran_bulan
                //                 $set('angsuran_bulan', round($total_installment, 2));
                //             }
                //         })
                //         ->label('Suku Jasa per bulan (%)'),

                //     // Number of Installments (Jangka Waktu)
                //     TextInput::make('num_installments')
                //         ->numeric()
                //         ->required()
                //         ->reactive() // Reactive to trigger recalculation
                //         ->afterStateUpdated(function (callable $set, $state, $get) {
                //             // Ambil data input dari form
                //             $principal = $get('nominal_pinjaman');  // Pinjaman Pokok
                //             $interest_rate = $get('interest_rate'); // Suku Bunga (%)
                //             $num_installments = $get('num_installments'); // Jangka Waktu (bulan)

                //             // Hitung angsuran per bulan
                //             if ($principal && $interest_rate && $num_installments) {
                //                 // $monthly_interest = $interest_rate / 100 * $principal;
                //                 $total_installment = $principal / $num_installments;

                //                 // Simpan hasilnya ke angsuran_bulan
                //                 $set('angsuran_bulan', round($total_installment, 2));
                //             }
                //         })
                //         ->label('Jangka Waktu (bulan)'),
                //         // Monthly Installment (Angsuran/Bulan)
                //     TextInput::make('angsuran_bulan')
                //         ->numeric()
                //         ->disabled()  // This field is calculated, so it's disabled for manual input
                //         ->label('Angsuran/Bulan')
                //         ->helperText('Kalkulasi Otomatis')
                //         ->reactive(),
                //     TextInput::make('angsuran_bulan_berikutnya')
                //         ->numeric()
                //         ->label('Angsuran/Bulan Berikutnya')
                //         ->reactive(),

                // ]),

            ])
            ->model(ModelsKreditKonvensional::class)
            ->statePath('data');
    }

    public function submitKredit(){
        // Ambil data dari form
        $data = $this->formKreditKonvensional->getState();
        $data['anggota_koperasi_id'] = $this->anggota_id;

        if ($this->kredit_id) {
            $simpok = ModelsKreditKonvensional::where('id', $this->kredit_id)->update($data);
            $simpok = ModelsKreditKonvensional::where('id', $this->kredit_id)->first();
            $k_id = $this->kredit_id;
        } else {
            $simpok = ModelsKreditKonvensional::create($data);
            $k_id = $simpok->id;
        }

        // Loan data from the form
        $principal = $data['pinjaman_pokok'];  // Pinjaman Pokok
        $interest_rate = $data['tarif_layanan']; // Suku Bunga (%)
        $num_installments = $data['jangka_waktu']; // Jangka Waktu (bulan)

        // Save the calculated monthly installment
        $total_installment = $principal / $num_installments;
        $simpok->angsuran_pokok_pertama = $total_installment;
        $simpok->save();

        // Inisialisasi variabel
        $pinjamanPokok = $principal;
        $jangkaWaktu = $num_installments;
        $tarifLayanan = $interest_rate;
        $angsuranPokokPertama = $total_installment; // Angsuran pokok pertama
        $angsuranPokokBerikutnya = $data['angsuran_pokok_berikutnya']; // Angsuran pokok berikutnya
        $tanggalMulai = $data['tanggal_mulai']; // Tanggal mulai

        // Fungsi menghitung selisih hari antara dua tanggal
        function selisihHari($start, $end) {
            $start = strtotime($start);
            $end = strtotime($end);
            return ($end - $start) / 86400;
        }

        // Fungsi menghitung bunga
        function hitungBunga($saldo, $tarifLayanan, $jumlahHari) {
            return ($saldo * $tarifLayanan / 100) * ($jumlahHari / 360);
        }

        // Fungsi menghitung tanggal jatuh tempo berikutnya
        function tanggalBerikutnya($tanggal, $bulanTambahan) {
            return date('Y-m-d', strtotime("+$bulanTambahan month", strtotime($tanggal)));
        }

        $tanggalJatuhTempoPertama = $data['tanggal_jatuh_tempo_pertama']; // Tanggal jatuh tempo pertama
        $saldo = $pinjamanPokok;
        $tanggalSekarang = $tanggalJatuhTempoPertama;

        // Array untuk menyimpan data angsuran
        $dataAngsuran = [];

        // Angsuran ke-0 (tidak ada pembayaran)
        $dataAngsuran[] = [
            'angsuran_ke' => 0,
            'tanggal_jatuh_tempo' => tanggalBerikutnya(date('Y-m', strtotime($tanggalMulai)) . '-25', 1), // Tanggal jatuh tempo
            'jumlah_hari' => 0,
            'pokok' => $saldo,
            'jumlah_angsuran' => 0.00,
            'angsuran_pokok' => 0.00,
            'angsuran_bunga' => 0.00,
            'baki_debet' => $saldo,
            'status_pokok' => 'Lunas',
            'status_bunga' => 'Lunas',
        ];

        // Angsuran pertama
        $jumlahHari = selisihHari($tanggalMulai, $tanggalSekarang);
        $bunga = hitungBunga($saldo, $tarifLayanan, $jumlahHari);
        $jumlahAngsuran = $angsuranPokokPertama + $bunga;

        // Insert untuk angsuran ke-1
        $dataAngsuran[] = [
            'angsuran_ke' => 1,
            'tanggal_jatuh_tempo' => date('Y-m-d', strtotime($tanggalSekarang)),
            'jumlah_hari' => $jumlahHari,
            'pokok' => $saldo,
            'jumlah_angsuran' => $jumlahAngsuran,
            'angsuran_pokok' => $angsuranPokokPertama,
            'angsuran_bunga' => $bunga,
            'baki_debet' => $saldo - $angsuranPokokPertama,
            'status_pokok' => 'Belum Lunas',
            'status_bunga' => 'Belum Lunas',
        ];

        $saldo -= $angsuranPokokPertama;

        // Loop untuk angsuran berikutnya
        for ($i = 2; $i <= $jangkaWaktu; $i++) {
            $tanggalSebelumnya = $tanggalSekarang;
            $tanggalSekarang = tanggalBerikutnya($tanggalSekarang, 1);
            $jumlahHari = selisihHari($tanggalSebelumnya, $tanggalSekarang);

            if ($i == $jangkaWaktu) {
                $angsuranPokok = $saldo;
            } else {
                $angsuranPokok = $angsuranPokokBerikutnya;
            }

            $bunga = hitungBunga($saldo, $tarifLayanan, $jumlahHari);
            $jumlahAngsuran = $angsuranPokok + $bunga;

            $dataAngsuran[] = [
                'angsuran_ke' => $i,
                'tanggal_jatuh_tempo' => date('Y-m-d', strtotime($tanggalSekarang)),
                'jumlah_hari' => $jumlahHari,
                'pokok' => $saldo,
                'jumlah_angsuran' => $jumlahAngsuran,
                'angsuran_pokok' => $angsuranPokok,
                'angsuran_bunga' => $bunga,
                'baki_debet' => $saldo - $angsuranPokok,
                'status_pokok' => 'Belum Lunas',
                'status_bunga' => 'Belum Lunas',
            ];

            $saldo -= $angsuranPokok;
        }

        // Untuk debugging, Anda bisa mencetak data angsuran

        foreach ($dataAngsuran as $key => $value) {
            # code...
            KreditKonvensionalAngsuran::create([
                'kredit_konvensional_id' => $k_id,
                'angsuran_ke' => $value['angsuran_ke'],
                'tanggal_jatuh_tempo' => $value['tanggal_jatuh_tempo'],
                'jumlah_hari' => $value['jumlah_hari'],
                'pokok' => $value['pokok'],
                'jumlah_angsuran' => $value['jumlah_angsuran'],
                'angsuran_pokok' => $value['angsuran_pokok'],
                'angsuran_bunga' => $value['angsuran_bunga'],
                'baki_debet' => $value['baki_debet'],
                'status_pokok' => $value['status_pokok'],
                'status_bunga' => $value['status_bunga'],
            ]);
        }


        $controller = new Controller();
        $controller->jurnal_umum('Pinjam', $pinjamanPokok, $this->anggota_id, null, null, $simpok->created_at);

        // Reset form
        $this->kredit_id = null;
        $this->formKreditKonvensional->fill();

        return Notification::make()->title('Berhasil disubmit!')->success()->send();
    }

    public function goHapusItemKredit($id){
        if (KreditKonvensionalAngsuran::where('kredit_konvensional_id',$id)->where('status_pokok','Lunas')->first()) {
            # code...
            return Notification::make()->title('Gagal dihapus!, angsuran sedang berjalan')->danger()->send();

        }

        $simpok = KreditKonvensionalAngsuran::where('kredit_konvensional_id',$id)->delete();
        $simpok = ModelsKreditKonvensional::where('id',$id)->first();

        $controller = new Controller();
        $controller->jurnal_umum('Pinjam', $simpok->nominal_pinjaman,$simpok->anggota_koperasi_id,null,null,$simpok->created_at,true);

        $simpok->delete();
        return Notification::make()->title('Berhasil dihapus!')->success()->send();

    }

    public function goBayarAngsuranPokok($id)
    {
        $kredit_angsuran = KreditKonvensionalAngsuran::where('id', $id)->first();
        $kredit = ModelsKreditKonvensional::where('id',$kredit_angsuran->kredit_konvensional_id)->first();
        $controller = new Controller();
        $controller->jurnal_umum('Bayar Pinjaman Pokok', $kredit_angsuran->angsuran_pokok, $kredit->anggota_koperasi_id, null, null, null);
        // Mark the principal installment (Angsuran Pokok) as paid
        KreditKonvensionalAngsuran::where('id', $id)->update(['status_pokok' => 'Lunas']);

        // Add notification or any additional logic
        Notification::make()->title('Angsuran Pokok berhasil dilunasi!')->success()->send();
    }

    public function goToggleShowKredit($id)
    {
        $key = array_search($id, $this->index_open_kredit);
        if ($key !== false) {
            unset($this->index_open_kredit[$key]);
        } else {
            $this->index_open_kredit[] = $id;
        }
    }

    public function goBayarAngsuranJasa($id)
    {
        $kredit_angsuran = KreditKonvensionalAngsuran::where('id', $id)->first();
        $kredit = ModelsKreditKonvensional::where('id',$kredit_angsuran->kredit_konvensional_id)->first();
        $controller = new Controller();
        $controller->jurnal_umum('Bayar Pinjaman Jasa', $kredit_angsuran->angsuran_bunga, $kredit->anggota_koperasi_id, null, null, null);
        // Mark the interest installment (Angsuran Bunga) as paid
        KreditKonvensionalAngsuran::where('id', $id)->update(['status_bunga' => 'Lunas']);

        // Add notification or any additional logic
        Notification::make()->title('Angsuran Bunga berhasil dilunasi!')->success()->send();
    }

    public function goUbahItemKredit($id){
        if (KreditAngsuran::where('kredit_id',$id)->where('status','Lunas')->first()) {
            # code...
            return Notification::make()->title('Gagal diubah!, angsuran sedang berjalan')->danger()->send();

        }
        $this->kredit_id = $id;
        $simpok = ModelsKreditKonvensional::where('id',$id)->first();

        $this->formKreditKonvensional->fill($simpok->toArray());

    }

    public function render()
    {
        $data['kredit'] = ModelsKreditKonvensional::with('kredit_konvensional_angsuran')->where('anggota_koperasi_id',$this->anggota_id)->where('kredit','Konvensional')->get();

        return view('livewire.anggota-koperasi-detail.kredit-konvensional',$data);
    }
}
