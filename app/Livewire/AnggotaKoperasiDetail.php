<?php

namespace App\Livewire;

use App\Http\Controllers\Controller;
use App\Models\AnggotaKoperasi;
use App\Models\Kredit;
use App\Models\KreditAngsuran;
use App\Models\SimpananPokokAnggota;
use App\Models\SimpananSukarelaAnggota;
use App\Models\SimpananWajibAnggota;
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

    // public $nominal,$tanggal;

    public ?array $data = [];

    public function mount($anggota_id){
        $this->anggota_id = $anggota_id;

        $this->anggota = AnggotaKoperasi::where('id',$anggota_id)->first();
        $this->formHeader->fill();
        $this->formSimpananPokok->fill();
        $this->formSimpananWajib->fill();
        $this->formSimpananSukarela->fill();
        $this->formKredit->fill();

    }

    protected function getForms(): array
    {
        return [
            'formHeader',
            'formSimpananPokok',
            'formSimpananWajib',
            'formSimpananSukarela',
            'formKredit',
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

    public function formSimpananPokok(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(4)->schema([TextInput::make('nominal')->numeric()->required(), DatePicker::make('tanggal')->required(), Select::make('d_k')->label('Debet/Kredit')->options(['Debet' => 'Debet', 'Kredit' => 'Kredit'])->required(), TextInput::make('deskripsi'), ]),

            ])
            ->model(SimpananPokokAnggota::class)->statePath('data');
    }

    public function formKredit(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)->schema([
                    TextInput::make('kredit')->required(),
                    TextInput::make('keterangan')->required(),

                 ]),
                 Grid::make(4)->schema([
                    TextInput::make('nominal_pinjaman')->numeric()->required(),
                    TextInput::make('dp')->numeric()->required(),
                    TextInput::make('nominal_pinjaman_margin')->label('Nominal Pinjaman + Margin')->numeric()->required(),
                    TextInput::make('tenor')->label('Tenor (bulan)')->numeric()->required(),
                 ]),

            ])
            ->model(Kredit::class)->statePath('data');
    }

    public function formSimpananWajib(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(4)->schema([TextInput::make('nominal')->numeric()->required(), DatePicker::make('tanggal')->required(), Select::make('d_k')->label('Debet/Kredit')->options(['Debet' => 'Debet', 'Kredit' => 'Kredit'])->required(), TextInput::make('deskripsi'), ]),

            ])
            ->model(SimpananWajibAnggota::class)->statePath('data');
    }

    public function formSimpananSukarela(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(4)->schema([TextInput::make('nominal')->numeric()->required(), DatePicker::make('tanggal')->required(), Select::make('d_k')->label('Debet/Kredit')->options(['Debet' => 'Debet', 'Kredit' => 'Kredit'])->required(), TextInput::make('deskripsi'), ]),

            ])
            ->model(SimpananSukarelaAnggota::class)->statePath('data');
    }

    public function submitKredit(){
        $data = $this->formKredit->getState();
        $data['anggota_koperasi_id'] = $this->anggota_id;

        if ($this->kredit_id) {
            # code...
            $simpok = Kredit::where('id',$this->kredit_id)->update($data);
            $simpok = Kredit::where('id',$this->kredit_id)->first();
            $k_id = $this->kredit_id;

        }else{
            $simpok = Kredit::create($data);
            $k_id = $simpok->id;
        }

        KreditAngsuran::where('kredit_id',$k_id)->delete();
        KreditAngsuran::create([
            'angsuran' => 'DP',
            'nominal' => $data['dp'],
            'kredit_id' => $k_id
        ]);

        $perbulan = ($data['nominal_pinjaman_margin'] - $data['dp']) / $data['tenor'];

        for ($i=1; $i <= $data['tenor'] ; $i++) {
            # code...
            KreditAngsuran::create([
                'angsuran' => 'Angsuran ke-'.$i,
                'nominal' => $perbulan,
                'kredit_id' => $k_id
            ]);
        }

        $controller = new Controller();
            # code...
            // $controller->jurnal_umum('Bayar Simpanan Pokok',$data['nominal'],$this->anggota_id,null,null,$simpok->created_at);



        $this->kredit_id = null;
        $this->simwa_id = null;
        $this->simsem_id = null;
        $this->formHeader->fill();
        $this->formSimpananPokok->fill();
        $this->formSimpananWajib->fill();
        $this->formSimpananSukarela->fill();
        $this->formKredit->fill();
        return Notification::make()->title('Berhasil disubmit!')->success()->send();

    }

    public function submitSimpananPokok(){
        $data = $this->formSimpananPokok->getState();
        $data['anggota_koperasi_id'] = $this->anggota_id;

        if ($this->simpok_id) {
            # code...
            $simpok = SimpananPokokAnggota::where('id',$this->simpok_id)->update($data);
            $simpok = SimpananPokokAnggota::where('id',$this->simpok_id)->first();

        }else{
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
        $this->formSimpananSukarela->fill();
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

    public function goHapusItemKredit($id){
        if (KreditAngsuran::where('kredit_id',$id)->where('status','Lunas')->first()) {
            # code...
            return Notification::make()->title('Gagal dihapus!, angsuran sedang berjalan')->danger()->send();

        }

        $simpok = KreditAngsuran::where('kredit_id',$id)->delete();
        $simpok = Kredit::where('id',$id)->first();

        $controller = new Controller();
        // $controller->jurnal_umum('Bayar Simpanan Pokok',$simpok->nominal,$simpok->anggota_koperasi_id,null,null,$simpok->created_at,true);

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

    public function submitSimpananWajib(){
        $data = $this->formSimpananWajib->getState();
        $data['anggota_koperasi_id'] = $this->anggota_id;

        if ($this->simwa_id) {
            # code...
            $simpok = SimpananWajibAnggota::where('id',$this->simwa_id)->update($data);
            $simpok = SimpananWajibAnggota::where('id',$this->simwa_id)->first();

        }else{
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
        return Notification::make()->title('Berhasil disubmit!')->success()->send();

    }

    public function goUbahItemSimpananSukarela($id){
        $this->simsem_id = $id;
        $simpok = SimpananSukarelaAnggota::where('id',$id)->first();

        $this->formSimpananSukarela->fill($simpok->toArray());

    }

    public function goHapusItemSimpananSukarela($id){
        $simpok = SimpananSukarelaAnggota::where('id',$id)->first();

        $controller = new Controller();
        $controller->jurnal_umum('Bayar Setoran Sukarela',$simpok->nominal,$simpok->anggota_koperasi_id,null,null,$simpok->created_at,true);

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

    public function render()
    {
        $data['simpanan_pokok'] = SimpananPokokAnggota::where('anggota_koperasi_id',$this->anggota_id)->get();
        $data['simpanan_wajib'] = SimpananWajibAnggota::where('anggota_koperasi_id',$this->anggota_id)->get();
        $data['simpanan_sukarela'] = SimpananSukarelaAnggota::where('anggota_koperasi_id',$this->anggota_id)->get();
        $data['kredit'] = Kredit::with('kredit_angsuran')->where('anggota_koperasi_id',$this->anggota_id)->get();
        return view('livewire.anggota-koperasi-detail',$data);
    }
}
