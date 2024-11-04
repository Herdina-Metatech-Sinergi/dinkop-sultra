<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnggotaKoperasiResource\Pages;
use App\Filament\Resources\AnggotaKoperasiResource\RelationManagers;
use App\Filament\Resources\AnggotaKoperasiResource\Widgets\AnggotaKoperasiDetailWidget;
use App\Models\AnggotaKoperasi;
use App\Models\IdentitasKoperasi;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AnggotaKoperasiResource extends Resource
{
    protected static ?string $model = AnggotaKoperasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Koperasi';


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
                Forms\Components\TextInput::make('no_anggota')
                    ->maxLength(255),
                Forms\Components\TextInput::make('ktp')
                    ->numeric()
                    ->maxLength(16),
                Forms\Components\TextInput::make('nama')
                    ->maxLength(255),
                Forms\Components\TextInput::make('alamat')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tgl_lahir'),
                Forms\Components\TextInput::make('tempat_lahir')
                    ->maxLength(255),
                Forms\Components\TextInput::make('no_hp')
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(255),
                Forms\Components\Select::make('jenis_kelamin')
                    ->options([
                        'Laki-laki' => 'Laki-laki',
                        'Perempuan' => 'Perempuan',
                    ])->required(),
                Forms\Components\DatePicker::make('tgl_masuk'),
                Forms\Components\DatePicker::make('tgl_keluar')->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('identitas_koperasi.nama_koperasi')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('no_anggota')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('alamat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tgl_lahir')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tempat_lahir')
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_hp')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
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
                Action::make('detail')->label('Detail')->action(function(AnggotaKoperasi $record) {
                    return redirect('admin/anggota-koperasis/'.$record->id.'/detail');
                }),

            ], position: ActionsPosition::BeforeColumns)
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
            'index' => Pages\ListAnggotaKoperasis::route('/'),
            'create' => Pages\CreateAnggotaKoperasi::route('/create'),
            'edit' => Pages\EditAnggotaKoperasi::route('/{record}/edit'),
            'detail' => Pages\AnggotaKoperasiDetail::route('/{record}/detail'),
        ];
    }

    // public static function getWidgets(): array
    // {
    //     return [
    //     ];
    // }
}
