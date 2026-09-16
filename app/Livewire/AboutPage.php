<?php

namespace App\Livewire;

use Livewire\Component;

class AboutPage extends Component
{
    public function render()
    {
        return view('livewire.about-page')
            ->layout('components.layouts.app', ['title' => 'Tentang Kami - Super Vacation']);
    }
}
