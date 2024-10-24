<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IdentitasKoperasiResource\Pages;
use App\Filament\Resources\IdentitasKoperasiResource\RelationManagers;
use App\Models\IdentitasKoperasi;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IdentitasKoperasiResource extends Resource
{
    protected static ?string $model = IdentitasKoperasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Koperasi';

    public static function shouldRegisterNavigation(): bool
    {
        // Hanya menampilkan menu jika pengguna memiliki role 'Admin Dinkop'
        return auth()->user()->hasRole('Admin Dinkop');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status','Menunggu')->count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_koperasi')
                    ->maxLength(255),
                Forms\Components\TextInput::make('no_badan_hukum')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tgl_badan_hukum'),
                Forms\Components\TextInput::make('nomor_pad_terakhir')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tgl_pad'),
                Forms\Components\Textarea::make('alamat')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('jalan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('desa_kelurahan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('kecamatan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('kabupaten_kota')
                    ->maxLength(255),
                Forms\Components\TextInput::make('provinsi')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_pengurus')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_pengawas')
                    ->maxLength(255),
                Forms\Components\TextInput::make('telp_fax_email')
                ->label('No Telepon')
                    ->maxLength(255),
                Forms\Components\TextInput::make('website')
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(255),
                Forms\Components\TextInput::make('npwp_koperasi')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nomor_rekening_nama_koperasi')
                    ->maxLength(255),
                Forms\Components\TextInput::make('bentuk_koperasi')
                    ->maxLength(255),
                Forms\Components\Select::make('jenis_koperasi')
                    ->options([
                        'Konsumen' => 'Konsumen',
                        'Produsen' => 'Produsen',
                        'Jasa' => 'Jasa',
                        'Pemasaran' => 'Pemasaran',
                        'Simpan Pinjam' => 'Simpan Pinjam',
                    ]),
                Forms\Components\TextInput::make('nomor_induk_koperasi_nik')
                    ->maxLength(255),
                Forms\Components\TextInput::make('iusp')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tgl_iusp'),
                Forms\Components\TextInput::make('nib')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tgl_nib'),
                Forms\Components\TextInput::make('jumlah_anggota_pria')
                    ->numeric(),
                Forms\Components\TextInput::make('jumlah_anggota_wanita')
                    ->numeric(),
                Forms\Components\TextInput::make('jumlah_kantor_cabang')
                    ->numeric(),
                Select::make('user_id')
                ->label('Pengguna')
                ->relationship('user', 'name') // Menggunakan relasi 'category' dengan menampilkan field 'name'
                ->required()
                ->searchable(),
                Forms\Components\TextInput::make('nama_simpanan_lainnya')
                    ->maxLength(50),
                Forms\Components\Select::make('status')
                    ->options([
                        'Menunggu' => 'Menunggu',
                        'Setujui' => 'Setujui',
                        'Tolak' => 'Tolak',
                    ])
                    ->hidden(!auth()->user()->hasRole(['Admin Dinkop'])),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_koperasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_badan_hukum')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tgl_badan_hukum')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nomor_pad_terakhir')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tgl_pad')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jalan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('desa_kelurahan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kecamatan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kabupaten_kota')
                    ->searchable(),
                Tables\Columns\TextColumn::make('provinsi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_pengurus')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_pengawas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telp_fax_email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('website')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('npwp_koperasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nomor_rekening_nama_koperasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bentuk_koperasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenis_koperasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nomor_induk_koperasi_nik')
                    ->searchable(),
                Tables\Columns\TextColumn::make('iusp')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tgl_iusp')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nib')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tgl_nib')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jumlah_anggota_pria')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jumlah_anggota_wanita')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jumlah_kantor_cabang')
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIdentitasKoperasis::route('/'),
            'create' => Pages\CreateIdentitasKoperasi::route('/create'),
            'edit' => Pages\EditIdentitasKoperasi::route('/{record}/edit'),
        ];
    }
}
