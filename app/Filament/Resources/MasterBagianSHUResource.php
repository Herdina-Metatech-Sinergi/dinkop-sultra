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
                Forms\Components\TextInput::make('total_shu')
                    ->label('Total SHU Koperasi')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('shu_bagian_anggota')
                    ->label('% SHU Bagian Anggota')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('simpanan_anggota')
                    ->label('Simpanan Anggota yang Bersangkutan')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('total_simpanan_anggota')
                    ->label('Total Simpanan Seluruh Anggota')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('transaksi_anggota')
                    ->label('Transaksi Anggota yang Bersangkutan')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('total_transaksi_anggota')
                    ->label('Total Transaksi Seluruh Anggota')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('shu_untuk_simpanan')
                    ->label('% SHU untuk Simpanan')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('shu_untuk_transaksi')
                    ->label('% SHU untuk Transaksi Anggota')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('total_shu')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('shu_bagian_anggota')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('simpanan_anggota')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_simpanan_anggota')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('transaksi_anggota')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_transaksi_anggota')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('shu_untuk_simpanan')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('shu_untuk_transaksi')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('identitas_koperasi_id')
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
