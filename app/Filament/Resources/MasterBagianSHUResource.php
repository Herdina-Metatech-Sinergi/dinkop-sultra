<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MasterBagianSHUResource\Pages;
use App\Filament\Resources\MasterBagianSHUResource\RelationManagers;
use App\Models\IdentitasKoperasi;
use App\Models\MasterBagianSHU;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MasterBagianSHUResource extends Resource
{
    protected static ?string $model = MasterBagianSHU::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Master Data';


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
                })->required()->searchable()->label('Koperasi'),
                Forms\Components\TextInput::make('cadangan')
                    ->label('% Cadangan')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('shu_bagian_anggota')
                    ->label('% SHU Bagian Anggota')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('shu_untuk_simpanan')
                    ->label('% SHU untuk Simpanan')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('shu_untuk_transaksi')
                    ->label('% SHU untuk Transaksi Anggota')->numeric(),

                Forms\Components\TextInput::make('dana_pendidikan')
                    ->label('% Dana Pendidikan')
                    ->required()
                    ->numeric(),

                Forms\Components\TextInput::make('insentif_pengurus_pengawas')
                    ->label('% Insentif Pengurus Pengawas')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('insentif_pengelola')
                    ->label('% Insentif Pengelola')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('dana_sosial')
                    ->label('% Dana Sosial')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('cadangan')
                    ->label('% Cadangan')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('shu_bagian_anggota')
                    ->label('% SHU Bagian Anggota')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('shu_untuk_simpanan')
                    ->label('% SHU untuk Simpanan')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('shu_untuk_transaksi')
                    ->label('% SHU untuk Transaksi Anggota')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('dana_pendidikan')
                    ->label('% Dana Pendidikan')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('insentif_pengurus_pengawas')
                    ->label('% Insentif Pengurus Pengawas')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('insentif_pengelola')
                    ->label('% Insentif Pengelola')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('dana_sosial')
                    ->label('% Dana Sosial')
                    ->numeric()
                    ->sortable(),


                Tables\Columns\TextColumn::make('identitas_koperasi.nama_koperasi')
                    ->numeric()
                    ->sortable(),
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

    public static function getEloquentQuery(): Builder
    {
        if (auth()->user()->hasRole('Admin Dinkop')) {
            // Jika user adalah Admin, tampilkan semua opsi
            $options = IdentitasKoperasi::get()->pluck( 'id')->first();
        } else {
            // Jika bukan Admin, tampilkan opsi yang sesuai dengan kondisi tertentu
            $options = IdentitasKoperasi::where('user_id', auth()->user()->id)
                                        ->pluck( 'id')->first();
        }

        if (auth()->user()->hasRole('Admin Dinkop')) {
            // Jika user adalah Admin, tampilkan semua opsi
            return parent::getEloquentQuery();
        } else {
            // Jika bukan Admin, tampilkan opsi yang sesuai dengan kondisi tertentu
            return parent::getEloquentQuery()
            ->where('identitas_koperasi_id', $options);
        }
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMasterBagianSHUS::route('/'),
            'create' => Pages\CreateMasterBagianSHU::route('/create'),
            'edit' => Pages\EditMasterBagianSHU::route('/{record}/edit'),
        ];
    }
}
