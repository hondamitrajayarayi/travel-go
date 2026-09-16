<?php

namespace App\Livewire;

use App\Models\Banner;
use App\Models\Testimonial;
use App\Models\Tour;
use Livewire\Component;

class HomePage extends Component
{
    public string $search = '';
    public string $selectedCategory = 'all'; // 'all', 'open_trip', 'private_trip'
    public string $selectedDestination = 'all';
    public string $selectedMonth = 'all';

    public function selectCategory(string $category): void
    {
        $this->selectedCategory = $category;
    }

    public function resetFilters(): void
    {
        $this->search = '';
        $this->selectedCategory = 'all';
        $this->selectedDestination = 'all';
        $this->selectedMonth = 'all';
    }

    public function render()
    {
        $banners = Banner::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->latest()
            ->get();

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

        $months = [
            '2026-09' => 'September 2026',
            '2026-10' => 'Oktober 2026',
            '2026-11' => 'November 2026',
            '2026-12' => 'Desember 2026',
            '2027-01' => 'Januari 2027',
            '2027-02' => 'Februari 2027',
            '2027-03' => 'Maret 2027',
            '2027-04' => 'April 2027',
            '2027-05' => 'Mei 2027',
        ];

        $testimonials = Testimonial::where('is_active', true)
            ->latest()
            ->take(7)
            ->get();

        return view('livewire.home-page', [
            'banners'      => $banners,
            'tours'        => $tours,
            'destinations' => $destinations,
            'months'       => $months,
            'testimonials' => $testimonials,
        ]);
    }
}
