<?php

namespace App\Livewire\Filament;

use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Artisan;
use Livewire\Component;

class ClearCacheButton extends Component
{
    public function clearCache(): void
    {
        try {
            Artisan::call('optimize:clear');

            Notification::make()
                ->title('Cache Berhasil Dibersihkan')
                ->body('Cache aplikasi, view blade, route, dan konfigurasi telah di-reset.')
                ->success()
                ->send();
        } catch (\Throwable $e) {
            Notification::make()
                ->title('Gagal Membersihkan Cache')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function render()
    {
        return view('livewire.filament.clear-cache-button');
    }
}
