<?php

namespace App\Livewire;

use Livewire\Component;

class PrivateTripPage extends Component
{
    public function render()
    {
        return view('livewire.private-trip-page')
            ->layout('components.layouts.app', [
                'title' => 'Private Trip & Custom Tour Eksklusif - Super Vacation',
                'description' => 'Layanan private trip dan custom tour eksklusif untuk keluarga, pasangan, honeymoon, dan small group dengan jadwal fleksibel dan pengalaman personal.'
            ]);
    }
}
