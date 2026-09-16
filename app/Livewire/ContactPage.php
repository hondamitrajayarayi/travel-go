<?php

namespace App\Livewire;

use App\Models\Contact;
use Livewire\Attributes\Rule;
use Livewire\Component;

class ContactPage extends Component
{
    #[Rule('required|string|min:3|max:100', message: [
        'required' => 'Nama lengkap wajib diisi.',
        'min'      => 'Nama minimal 3 karakter.',
    ])]
    public string $name = '';

    #[Rule('required|email|max:150', message: [
        'required' => 'Alamat email wajib diisi.',
        'email'    => 'Format email tidak valid.',
    ])]
    public string $email = '';

    #[Rule('nullable|string|max:30')]
    public string $phone = '';

    #[Rule('required|string|min:3|max:150', message: [
        'required' => 'Subjek pesan wajib diisi.',
        'min'      => 'Subjek minimal 3 karakter.',
    ])]
    public string $subject = '';

    #[Rule('required|string|min:10|max:2000', message: [
        'required' => 'Pesan wajib diisi.',
        'min'      => 'Pesan minimal 10 karakter.',
    ])]
    public string $message = '';

    public bool $isSubmitted = false;

    public function submit()
    {
        $this->validate();

        Contact::create([
            'name'    => $this->name,
            'email'   => $this->email,
            'phone'   => $this->phone,
            'subject' => $this->subject,
            'message' => $this->message,
            'status'  => 'unread',
        ]);

        $this->reset(['name', 'email', 'phone', 'subject', 'message']);
        $this->isSubmitted = true;
    }

    public function resetForm()
    {
        $this->isSubmitted = false;
    }

    public function render()
    {
        return view('livewire.contact-page')
            ->layout('components.layouts.app', ['title' => 'Contact Us - Super Vacation']);
    }
}
