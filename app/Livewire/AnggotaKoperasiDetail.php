<?php

namespace App\Livewire;

use App\Http\Controllers\Controller;
use App\Models\AnggotaKoperasi;
use App\Models\SimpananPokokAnggota;
use App\Models\SimpananSukarelaAnggota;
use App\Models\SimpananWajibAnggota;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
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
    // public $nominal,$tanggal;

    public ?array $data = [];

    public function mount($anggota_id){
        $this->anggota_id = $anggota_id;

        $this->anggota = AnggotaKoperasi::where('id',$anggota_id)->first();
        $this->formHeader->fill();
        $this->formSimpananPokok->fill();
        $this->formSimpananWajib->fill();
        $this->formSimpananSukarela->fill();

    }

    protected function getForms(): array
    {
        return [
            'formHeader',
            'formSimpananPokok',
            'formSimpananWajib',
            'formSimpananSukarela',
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
                Grid::make(3)->schema([TextInput::make('nominal')->numeric()->required(), DatePicker::make('tanggal')->required()]),

            ])
            ->model(SimpananPokokAnggota::class)->statePath('data');
    }

    public function formSimpananWajib(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)->schema([TextInput::make('nominal')->numeric()->required(), DatePicker::make('tanggal')->required()]),

            ])
            ->model(SimpananWajibAnggota::class)->statePath('data');
    }

    public function formSimpananSukarela(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)->schema([TextInput::make('nominal')->numeric()->required(), DatePicker::make('tanggal')->required()]),

            ])
            ->model(SimpananSukarelaAnggota::class)->statePath('data');
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
        $controller->jurnal_umum('Bayar Simpanan Pokok',$data['nominal'],$this->anggota_id,null,null,$simpok->created_at);

        $this->simpok_id = null;
        $this->simwa_id = null;
        $this->simsem_id = null;
        $this->formHeader->fill();
        $this->formSimpananPokok->fill();
        $this->formSimpananWajib->fill();
        $this->formSimpananSukarela->fill();
        return Notification::make()->title('Berhasil disubmit!')->success()->send();

    }

    public function goUbahItemSimpananPokok($id){
        $this->simpok_id = $id;
        $simpok = SimpananPokokAnggota::where('id',$id)->first();

        $this->formSimpananPokok->fill($simpok->toArray());

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
        $controller->jurnal_umum('Bayar Simpanan Wajib',$data['nominal'],$this->anggota_id,null,null,$simpok->created_at);

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
        $controller->jurnal_umum('Bayar Setoran Sukarela',$data['nominal'],$this->anggota_id,null,null,$simpok->created_at);

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

    public function render()
    {
        $data['simpanan_pokok'] = SimpananPokokAnggota::where('anggota_koperasi_id',$this->anggota_id)->latest()->get();
        $data['simpanan_wajib'] = SimpananWajibAnggota::where('anggota_koperasi_id',$this->anggota_id)->latest()->get();
        $data['simpanan_sukarela'] = SimpananSukarelaAnggota::where('anggota_koperasi_id',$this->anggota_id)->latest()->get();
        return view('livewire.anggota-koperasi-detail',$data);
    }
}
