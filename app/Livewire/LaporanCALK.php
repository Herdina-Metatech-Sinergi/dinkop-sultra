<?php

namespace App\Livewire;

use App\Models\IdentitasKoperasi;
use Carbon\Carbon;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;

class LaporanCALK extends Component implements HasForms
{
    use InteractsWithForms;

    public $filters = [
        'tgl_awal' => null,
        'tgl_akhir' => null,
        'identitas_koperasi_id' => null,
        'calk' => null,
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
        $this->filters['calk']  = "

    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
            background-color: #f9f9f9;
        }
        h1, h2, h3 {
            color: #2c3e50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #34495e;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>


<h1>Koperasi ...</h1>
<h2>Catatan Atas Laporan Keuangan</h2>
<p><em>Untuk periode tahun yang berakhir pada tanggal</em></p>
<p><em>Disajikan dalam Rupiah, kecuali dinyatakan lain</em></p>

<h3>UMUM</h3>

<h4>Pendirian</h4>
<p>Koperasi … didirikan pada tanggal … dan telah didaftarkan dalam Daftar Umum Kantor Wilayah Koperasi Provinsi Jawa Timur tertanggal 15 Januari 1980 sebagai Badan Hukum dengan nomor ....</p>
<p>Akta Koperasi Wanita Setia Bhakti Wanita Jawa Timur mengalami perubahan terakhir sesuai dengan Akta Notaris Nomor 2 tanggal 29 Juni 2012, disahkan oleh Kepala Badan Penanaman Modal Provinsi Jawa Timur a.n. Gubernur Jawa Timur, berdasarkan Akta No.18 oleh Notaris MH., di Surabaya. Kemudian didaftarkan ke Direktorat Jenderal Administrasi Hukum Umum, Kementerian Hukum dan HAM RI tertanggal ... dengan Nomor ....</p>

<h4>Legalitas yang Dimiliki</h4>
<ul>
    <li>Kartu Nomor Wajib Pajak (NPWP)</li>
    <li>Surat Izin Usaha Simpan Pinjam dari Pemerintah Provinsi Jawa Timur</li>
    <li>SIUP Besar dari Dinas Penanaman Modal dan PTSP Pemkot Surabaya</li>
    <li>TDP dari Dinas PTSP Pemkot Surabaya</li>
    <li>Sertifikat Nomor Induk Koperasi (NIK) dari Kementerian Koperasi dan UKM RI</li>
    <li>Izin Mendirikan Bangunan (IMB) dari Dinas Perumahan Rakyat Kota Surabaya</li>
    <li>Surat Izin Usaha Toko Swalayan (IUTS) dari Dinas Perdagangan Kota Surabaya</li>
    <li>NIB dari Pemerintah RI c.q OSS</li>
</ul>

<h4>Tujuan & Kegiatan Usaha</h4>
<p>Tujuan Koperasi Jawa Timur sesuai Anggaran Dasar Pasal 4:</p>
<ul>
    <li>Meningkatkan kesejahteraan anggota dan masyarakat daerah kerja.</li>
    <li>Menjadi gerakan ekonomi rakyat dan ikut membangun perekonomian nasional.</li>
</ul>
<p>Kegiatan usaha terdiri dari:</p>
<ul>
    <li>Unit Simpan Pinjam</li>
    <li>Unit Pertokoan</li>
    <li>Unit Jasa</li>
</ul>

<h4>Tempat dan Kedudukan</h4>
<p>Koperasi Jawa Timur: Jl. Surabaya.</p>

<h4>Organisasi</h4>
<h5>Rapat Anggota</h5>
<p>Rapat Anggota adalah forum dengan kekuasaan tertinggi di koperasi. Dilaksanakan minimal 1 kali setahun, sekaligus untuk pertanggungjawaban pengurus kepada anggota.</p>

<h5>Susunan Pengurus dan Pengawas</h5>
<p>Susunan Pengurus Koperasi Jawa Timur masa bakti 2020-2022:</p>

<table>
    <tr>
        <th>Jabatan</th>
        <th>Nama</th>
    </tr>
    <tr>
        <td>Ketua</td>
        <td>...</td>
    </tr>
    <tr>
        <td>Wakil Ketua I</td>
        <td>...</td>
    </tr>
    <tr>
        <td>Wakil Ketua II</td>
        <td>...</td>
    </tr>
    <tr>
        <td>Sekretaris I</td>
        <td>...</td>
    </tr>
    <tr>
        <td>Sekretaris II</td>
        <td>...</td>
    </tr>
    <tr>
        <td>Bendahara I</td>
        <td>...</td>
    </tr>
    <tr>
        <td>Bendahara II</td>
        <td>...</td>
    </tr>
</table>

<h3>KEBIJAKAN AKUNTANSI</h3>

<h4>Standar Akuntansi Keuangan</h4>
<p>Standar Akuntansi menggunakan SAK ETAP, diterbitkan oleh IAPI. Tahun buku koperasi adalah 1 Januari hingga 31 Desember.</p>

<h4>Dasar Penyusunan Laporan Keuangan</h4>
<p>Laporan Keuangan disusun berdasarkan prinsip kesinambungan (going concern) dan konvensi harga historis.</p>

<h4>Penyajian Laporan Keuangan</h4>
<ul>
    <li>Neraca</li>
    <li>Perhitungan Hasil Usaha</li>
    <li>Laporan Perubahan Ekuitas</li>
    <li>Laporan Arus Kas</li>
    <li>Catatan Atas Laporan Keuangan</li>
</ul>

<h4>Pengakuan Pendapatan dan Beban</h4>
<p>Pendapatan dan beban dicatat menggunakan basis akrual. Pengakuan pendapatan meliputi:</p>
<ul>
    <li>Penjualan barang dagangan: Saat transaksi atau penyerahan barang.</li>
    <li>Pendapatan jasa simpan pinjam: Akrual untuk kelompok lancar.</li>
    <li>Pendapatan jasa lainnya: Saat penyerahan jasa.</li>
</ul>

<h4>Persediaan</h4>
<p>Dicatat dengan metode FIFO. Persediaan rusak dibebankan ke perhitungan hasil usaha.</p>

<h4>Aset Tetap</h4>
<p>Aset tetap dicatat berdasarkan biaya perolehan dikurangi akumulasi penyusutan. Metode penyusutan menggunakan garis lurus dengan umur ekonomis:</p>

<table>
    <tr>
        <th>Kategori Aset</th>
        <th>Umur Ekonomis</th>
        <th>Tarif</th>
    </tr>
    <tr>
        <td>Bangunan Permanen</td>
        <td>20 Tahun</td>
        <td>5%</td>
    </tr>
    <tr>
        <td>Kendaraan Roda 4</td>
        <td>8 Tahun</td>
        <td>12,5%</td>
    </tr>
</table>

<h4>Sisa Hasil Usaha (SHU)</h4>
<table>
    <tr>
        <th>Alokasi</th>
        <th>Persentase</th>
    </tr>
    <tr>
        <td>Cadangan</td>
        <td>10%</td>
    </tr>
    <tr>
        <td>Jasa Usaha Anggota</td>
        <td>34%</td>
    </tr>
</table>



        ";

    }

    public function getFilterFormSchema(Form $form): Form
    {
        return $form
            ->schema([
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
                    })->searchable()->required()->label('Identitas Koperasi'),
                ]),
                Grid::make(1)->schema([

                    RichEditor::make('filters.calk')->lazy()
                        ->required(),
                ])
            ])->model(JurnalUmum::class);
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

            session()->put('calk', $this->filters['calk']);


            $_url = '/admin/cetak/laporan-calk?tgl_awal=' . $tgl_awal->toDateString() . '&tgl_akhir=' . $tgl_akhir->toDateString() . '&identitas_koperasi_id=' . $this->filters['identitas_koperasi_id'];
            return redirect($_url);
            // $this->dispatch('download-export', $_url);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function render()
    {
        return view('livewire.laporan-c-a-l-k');
    }
}
