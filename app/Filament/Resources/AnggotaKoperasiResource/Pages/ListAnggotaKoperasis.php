<?php

namespace App\Filament\Resources\AnggotaKoperasiResource\Pages;

use App\Exports\TemplateAnggotaKoperasiExport;
use App\Filament\Resources\AnggotaKoperasiResource;
use App\Models\AnggotaKoperasi;
use App\Models\IdentitasKoperasi;
use Filament\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Collection;

class ListAnggotaKoperasis extends ListRecords
{
    protected static string $resource = AnggotaKoperasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \EightyNine\ExcelImport\ExcelImportAction::make()
                ->color("primary")
                ->sampleExcel(
                    sampleData: [
                        [
                            "no_anggota" => "001",
                            "ktp" => "1234567890123456",
                            "nama" => "Ahmad Syahputra",
                            "alamat" => "Jl. Mawar No. 10, Jakarta",
                            "tempat_lahir" => "Jakarta",
                            "tgl_lahir" => "1990-01-01",
                            "no_hp" => "081234567890",
                            "email" => "ahmad@example.com",
                            "jenis_kelamin" => "Laki-laki",
                            "tgl_masuk" => "2023-01-01"
                        ],
                        [
                            "no_anggota" => null,
                            "ktp" => "2345678901234567",
                            "nama" => "Sri Rahayu",
                            "alamat" => "Jl. Melati No. 5, Bandung",
                            "tempat_lahir" => "Bandung",
                            "tgl_lahir" => "1992-02-15",
                            "no_hp" => "081298765432",
                            "email" => "sri@example.com",
                            "jenis_kelamin" => "Perempuan",
                            "tgl_masuk" => "2023-02-15"
                        ],
                        [
                            "no_anggota" => "003",
                            "ktp" => "3456789012345678",
                            "nama" => "Budi Santoso",
                            "alamat" => "Jl. Anggrek No. 7, Surabaya",
                            "tempat_lahir" => "Surabaya",
                            "tgl_lahir" => "1985-03-20",
                            "no_hp" => "081345678901",
                            "email" => "budi@example.com",
                            "jenis_kelamin" => "Laki-laki",
                            "tgl_masuk" => "2023-03-20"
                        ],
                        [
                            "no_anggota" => null,
                            "ktp" => "4567890123456789",
                            "nama" => "Dewi Kusuma",
                            "alamat" => "Jl. Kenanga No. 3, Yogyakarta",
                            "tempat_lahir" => "Yogyakarta",
                            "tgl_lahir" => "1995-04-10",
                            "no_hp" => "081456789012",
                            "email" => "dewi@example.com",
                            "jenis_kelamin" => "Perempuan",
                            "tgl_masuk" => "2023-04-10"
                        ],
                        [
                            "no_anggota" => "005",
                            "ktp" => "5678901234567890",
                            "nama" => "Andi Pratama",
                            "alamat" => "Jl. Flamboyan No. 12, Medan",
                            "tempat_lahir" => "Medan",
                            "tgl_lahir" => "1988-05-05",
                            "no_hp" => "081567890123",
                            "email" => "andi@example.com",
                            "jenis_kelamin" => "Laki-laki",
                            "tgl_masuk" => "2023-05-05"
                        ]
                    ],
                    fileName: 'template_anggota_koperasi.xlsx',
                    // exportClass: TemplateAnggotaKoperasiExport::class,
                    sampleButtonLabel: 'Unduh Format Pengisian',
                    customiseActionUsing: fn(Action $action) => $action->color('secondary')
                        ->icon('heroicon-m-clipboard')
                        ->requiresConfirmation(),
                )
                ->validateUsing([
                    'no_anggota' => 'nullable|string',
                    'ktp' => 'required|digits:16',
                    'nama' => 'required|string|max:255',
                    'alamat' => 'required|string|max:255',
                    'tempat_lahir' => 'required|string|max:255',
                    'tgl_lahir' => 'required|date',
                    'no_hp' => ['required', 'numeric', 'digits_between:10,15'],
                    'email' => 'required|email',
                    'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                    'tgl_masuk' => 'required|date',
                ])
                ->processCollectionUsing(function (string $modelClass, Collection $collection) {
                    // Do some stuff with the collection

                    if (auth()->user()->hasRole('Admin Dinkop')) {
                        $identitas_koperasi_id = IdentitasKoperasi::get()->pluck('id')->first();
                    } else {
                        $identitas_koperasi_id = IdentitasKoperasi::where('user_id', auth()->user()->id)
                                                        ->pluck('id')
                                                        ->first();
                    }

                    foreach ($collection as $key => $value) {
                        # code...
                        if ($value['no_anggota'] == null) {
                            # code...
                            $cek_urutan = AnggotaKoperasi::where(['identitas_koperasi_id' => $identitas_koperasi_id])->whereYear('created_at',date('Y'))->count() + 1;
                            $no_anggota = $identitas_koperasi_id.date('Y').str_pad($cek_urutan, 5, '0', STR_PAD_LEFT);
                            $value['no_anggota'] = $no_anggota;
                        }

                        $value['identitas_koperasi_id'] = $identitas_koperasi_id;

                        AnggotaKoperasi::create($value->toArray());
                    }
                    Notification::make()->title('Anggota berhasil diimport')->success()->send();

                    return $collection;
                }),
            Actions\CreateAction::make(),
        ];
    }
}
