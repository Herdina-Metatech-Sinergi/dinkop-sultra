<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransaksiUmumResource\Pages;
use App\Filament\Resources\TransaksiUmumResource\RelationManagers;
use App\Models\IdentitasKoperasi;
use App\Models\KonfigurasiCOA;
use App\Models\MasterCoa;
use App\Models\TransaksiUmum;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransaksiUmumResource extends Resource
{
    protected static ?string $model = TransaksiUmum::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Input Data';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('identitas_koperasi_id')->options(function () {
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
                })->searchable()->required()->label('Identitas Koperasi')->required()->searchable()->label('Koperasi'),
                Select::make('konfigurasi_coa')->options(MasterCoa::whereRaw('LENGTH(kode_coa) >= 4')
                ->where(function ($query) {
                    $query->where('kode_coa', 'like', '4%')
                          ->orWhere('kode_coa', 'like', '5%');
                })
                ->get()
                ->pluck('title', 'kode_coa')
            )->required()->searchable()->label('Transaksi')
            ->createOptionForm([
                Forms\Components\TextInput::make('title')->label('Nama COA')
                    ->required(),
                Forms\Components\Select::make('kategori')
                    ->required()
                    ->options(function (){
                        $mc = MasterCoa::whereRaw('LENGTH(kode_coa) = 2')
                            ->where(function ($query) {
                                $query->where('kode_coa', 'like', '4%')
                                    ->orWhere('kode_coa', 'like', '5%');
                            })
                            ->get()
                            ->pluck('title', 'id');
                        return $mc;
                    }),
            ])->createOptionUsing(function (array $data): int {
                $mascoa = MasterCoa::with('children')->where('id',$data['kategori'])->first();
                $mascoa_kode = $mascoa->children->max('kode_coa') + 1;

                $mc_new = MasterCoa::create([
                    'title' => $data['title'],
                    'kelompok' => $data['title'],
                    'kode_coa' => $mascoa_kode,
                    'saldo_normal' => $mascoa->saldo_normal,
                    'parent_id' => $mascoa->id
                ]);

                return $mc_new->id;
            })->helperText('Silahkan refresh halaman bila sudah menambahkan data baru transaksi'),
                Forms\Components\DatePicker::make('tanggal')
                    ->required(),
                Forms\Components\TextInput::make('nominal')
                    ->numeric()->required(),
                Forms\Components\TextInput::make('deskripsi')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('master_coa.title')->label('COA')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nominal')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deskripsi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransaksiUmums::route('/'),
            'create' => Pages\CreateTransaksiUmum::route('/create'),
            'edit' => Pages\EditTransaksiUmum::route('/{record}/edit'),
        ];
    }
}
