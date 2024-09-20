<?php

namespace App\Filament\Auth;

use App\Models\IdentitasKoperasi;
use Filament\Pages\Auth\Register as AuthRegister;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Illuminate\Database\Eloquent\Model;


class Register extends AuthRegister
{

    protected function handleRegistration(array $data): Model
    {
        $user = $this->getUserModel()::create($data);
        $user->assignRole('Admin Koperasi');

        IdentitasKoperasi::create([
            'nama_koperasi' => $data['nama_koperasi'],
            'telp_fax_email' => $data['telp_fax_email'],
            'user_id' => $user->id,
            'email' => $data['email']
        ]);

        return $user;
    }

    public function form(Form $form):Form
    {
        return $form->schema([
            $this->getNameFormComponent(),
            $this->getEmailFormComponent(),
            $this->getPasswordFormComponent(),
            $this->getPasswordConfirmationFormComponent(),
            TextInput::make('nama_koperasi')->label('Nama Koperasi')->required(),
            TextInput::make('telp_fax_email')->label('No. Telp Koperasi')->numeric()->required(),
        ])
        ->statePath('data');
    }
}
