<?php

namespace App\Livewire;

use App\Models\Testimonial;
use App\Models\Tour;
use Livewire\Component;

class HomePage extends Component
{
    public string $search = '';
    public string $selectedCategory = 'all'; // 'all', 'open_trip', 'private_trip'
    public string $selectedDestination = 'all';

    public function selectCategory(string $category): void
    {
        $this->selectedCategory = $category;
    }

    public function resetFilters(): void
    {
        $this->search = '';
        $this->selectedCategory = 'all';
        $this->selectedDestination = 'all';
    }

    public function render()
    {
        $toursQuery = Tour::query()
            ->when($this->search !== '', function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('destination', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->selectedDestination !== 'all', function ($query) {
                $query->where('destination', 'like', '%' . $this->selectedDestination . '%');
            });

        // Filter berdasarkan kategori
        if ($this->selectedCategory === 'open_trip') {
            $toursQuery->where(function ($q) {
                $q->where('title', 'like', '%Open Trip%')
                  ->orWhere('description', 'like', '%Open Trip%');
            });
        } elseif ($this->selectedCategory === 'private_trip') {
            $toursQuery->where(function ($q) {
                $q->where('title', 'like', '%Private%')
                  ->orWhere('description', 'like', '%Private%');
            });
        }

        $tours = $toursQuery->latest()->get();

        // Ambil daftar destinasi unik untuk dropdown filter
        $destinations = Tour::select('destination')
            ->distinct()
            ->pluck('destination');

        $testimonials = Testimonial::where('is_active', true)
            ->latest()
            ->take(7)
            ->get();

        return view('livewire.home-page', [
            'tours'        => $tours,
            'destinations' => $destinations,
            'testimonials' => $testimonials,
        ]);
    }
}
