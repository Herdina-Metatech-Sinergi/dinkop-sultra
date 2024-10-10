<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransaksiUmumResource\Pages;
use App\Filament\Resources\TransaksiUmumResource\RelationManagers;
use App\Models\IdentitasKoperasi;
use App\Models\KonfigurasiCOA;
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
    protected static ?string $navigationGroup = 'Koperasi';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('identitas_koperasi_id')->options(function () {
                    // Cek apakah user memiliki role "Admin"
                    if (auth()->user()->hasRole('Admin')) {
                        // Jika user adalah Admin, tampilkan semua opsi
                        return IdentitasKoperasi::get()->pluck('nama_koperasi', 'id');
                    } else {
                        // Jika bukan Admin, tampilkan opsi yang sesuai dengan kondisi tertentu
                        return IdentitasKoperasi::where('user_id', auth()->user()->id)
                                                ->pluck('nama_koperasi', 'id');
                    }
                })->required()->searchable()->label('Koperasi'),
                Select::make('konfigurasi_coa')->options(function () {
                    // Cek apakah user memiliki role "Admin"

                        // Jika bukan Admin, tampilkan opsi yang sesuai dengan kondisi tertentu
                    $konf_coa = KonfigurasiCOA::get()->groupBy('nama');
                    $kon = [];
                    foreach ($konf_coa as $key => $value) {
                        # code...
                        $kon [$key] = $key;
                    }
                    return $kon;
                })->required()->searchable()->label('Transaksi'),
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

                Tables\Columns\TextColumn::make('konfigurasi_coa')
                    ->numeric()
                    ->sortable(),
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
