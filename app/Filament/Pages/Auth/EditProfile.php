<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;

class EditProfile extends BaseEditProfile
{
    public static function getLabel(): string
    {
        return 'Ganti Password & Profil';
    }

    public function getHeading(): string
    {
        return 'Ganti Password & Profil Admin';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Akun')
                    ->description('Perbarui nama dan alamat email akun admin Anda.')
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                    ])
                    ->columns(2),

                Section::make('Ubah Password')
                    ->description('Kosongkan jika Anda tidak ingin mengubah password saat ini.')
                    ->schema([
                        $this->getPasswordFormComponent()
                            ->label('Password Baru')
                            ->placeholder('Masukkan password baru (minimal 8 karakter)'),
                        $this->getPasswordConfirmationFormComponent()
                            ->label('Konfirmasi Password Baru')
                            ->placeholder('Ulangi password baru'),
                    ])
                    ->columns(2),
            ]);
    }
}
