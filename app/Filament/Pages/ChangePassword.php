<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ChangePassword extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-key';

    protected static ?string $navigationLabel = 'Ganti Password';

    protected static ?string $title = 'Ganti Password Admin';

    protected static ?string $navigationGroup = 'Pengaturan Akun';

    protected static ?int $navigationSort = 99;

    protected static string $view = 'filament.pages.change-password';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Ubah Password')
                    ->description('Silakan masukkan password saat ini dan tentukan password baru yang aman.')
                    ->schema([
                        TextInput::make('current_password')
                            ->label('Password Saat Ini')
                            ->password()
                            ->revealable()
                            ->required()
                            ->currentPassword(),

                        TextInput::make('password')
                            ->label('Password Baru')
                            ->password()
                            ->revealable()
                            ->required()
                            ->rule(Password::default()->min(8))
                            ->same('password_confirmation')
                            ->helperText('Minimal 8 karakter.'),

                        TextInput::make('password_confirmation')
                            ->label('Konfirmasi Password Baru')
                            ->password()
                            ->revealable()
                            ->required(),
                    ])
                    ->columns(1),
            ])
            ->statePath('data');
    }

    public function updatePassword(): void
    {
        $state = $this->form->getState();

        $user = auth()->user();
        $user->update([
            'password' => Hash::make($state['password']),
        ]);

        $this->form->fill();

        Notification::make()
            ->title('Password Berhasil Diubah')
            ->body('Password akun Anda telah berhasil diperbarui.')
            ->success()
            ->send();
    }
}
