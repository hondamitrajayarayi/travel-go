<?php

namespace App\Livewire;

use Livewire\Component;

class TermsPage extends Component
{
    public function render()
    {
        return view('livewire.terms-page')
            ->layout('components.layouts.app', ['title' => 'Terms & Conditions - Super Vacation']);
    }
}
