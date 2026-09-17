<?php

namespace App\Livewire;

use App\Models\Country;
use App\Models\Tour;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class TourSchedulePage extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $selectedCategory = 'all'; // 'all', 'open_trip', 'private_trip'

    #[Url]
    public string $selectedDestination = 'all';

    #[Url]
    public string $selectedCountry = 'all';

    #[Url]
    public array $selectedMonths = [];

    #[Url]
    public array $selectedYears = [];

    #[Url]
    public string $selectedMonth = 'all';

    public int $perPage = 9;

    public function mount(): void
    {
        // Tangkap selectedMonth jika dikirim dari URL/Homepage (format '2026-09' atau '9')
        if ($this->selectedMonth !== 'all' && !empty($this->selectedMonth)) {
            if (str_contains($this->selectedMonth, '-')) {
                $parts = explode('-', $this->selectedMonth);
                $year = (int)$parts[0];
                $month = (int)$parts[1];
                if (!in_array((string)$month, $this->selectedMonths)) {
                    $this->selectedMonths[] = (string)$month;
                }
                if (!in_array((string)$year, $this->selectedYears)) {
                    $this->selectedYears[] = (string)$year;
                }
            } else {
                $month = (int)$this->selectedMonth;
                if (!in_array((string)$month, $this->selectedMonths)) {
                    $this->selectedMonths[] = (string)$month;
                }
            }
        }
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedSelectedCountry(): void
    {
        $this->resetPage();
    }

    public function updatedSelectedMonths(): void
    {
        $this->resetPage();
    }

    public function updatedSelectedYears(): void
    {
        $this->resetPage();
    }

    public function updatedSelectedCategory(): void
    {
        $this->resetPage();
    }

    public function selectCategory(string $category): void
    {
        $this->selectedCategory = $category;
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->search = '';
        $this->selectedCategory = 'all';
        $this->selectedDestination = 'all';
        $this->selectedCountry = 'all';
        $this->selectedMonth = 'all';
        $this->selectedMonths = [];
        $this->selectedYears = [];
        $this->resetPage();
    }

    public function render()
    {
        $monthsList = [
            '1'  => 'Januari',
            '2'  => 'Februari',
            '3'  => 'Maret',
            '4'  => 'April',
            '5'  => 'Mei',
            '6'  => 'Juni',
            '7'  => 'Juli',
            '8'  => 'Agustus',
            '9'  => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];

        $toursQuery = Tour::query()
            ->when($this->search !== '', function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('destination', 'like', '%' . $this->search . '%')
                      ->orWhere('season', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->selectedDestination !== 'all', function ($query) {
                $query->where('destination', 'like', '%' . $this->selectedDestination . '%');
            })
            ->when($this->selectedCountry !== 'all', function ($query) {
                $country = Country::find($this->selectedCountry);
                $countryName = $country ? $country->name : $this->selectedCountry;
                $query->where(function ($q) use ($countryName) {
                    $q->where('country_id', $this->selectedCountry)
                      ->orWhere('destination', 'like', '%' . $countryName . '%')
                      ->orWhere('title', 'like', '%' . $countryName . '%');
                });
            })
            ->when($this->selectedMonth !== 'all' && empty($this->selectedMonths), function ($query) use ($monthsList) {
                if (str_contains($this->selectedMonth, '-')) {
                    $parts = explode('-', $this->selectedMonth);
                    $mNum = (int) $parts[1];
                    $mName = $monthsList[(string)$mNum] ?? '';
                    $query->where(function ($q) use ($parts, $mNum, $mName) {
                        $q->where(function ($sub) use ($parts) {
                            $sub->whereYear('start_date', $parts[0])
                                ->whereMonth('start_date', $parts[1]);
                        })
                        ->orWhere('season', 'like', '%' . $parts[0] . '%')
                        ->orWhere('title', 'like', '%' . $parts[0] . '%');

                        if ($mName) {
                            $q->orWhere('season', 'like', '%' . $mName . '%');
                        }
                    });
                } else {
                    $mNum = (int) $this->selectedMonth;
                    $mName = $monthsList[(string)$mNum] ?? '';
                    $query->where(function ($q) use ($mNum, $mName) {
                        $q->whereMonth('start_date', $mNum);
                        if ($mName) {
                            $q->orWhere('season', 'like', '%' . $mName . '%');
                        }
                    });
                }
            })
            ->when(!empty($this->selectedMonths), function ($query) use ($monthsList) {
                $query->where(function ($q) use ($monthsList) {
                    foreach ($this->selectedMonths as $monthNum) {
                        $mInt = (int)$monthNum;
                        $mName = $monthsList[(string)$mInt] ?? '';
                        $q->orWhereMonth('start_date', $mInt);
                        if (!empty($mName)) {
                            $q->orWhere('season', 'like', '%' . $mName . '%')
                              ->orWhere('title', 'like', '%' . $mName . '%')
                              ->orWhere('description', 'like', '%' . $mName . '%');
                        }
                    }
                });
            })
            ->when(!empty($this->selectedYears), function ($query) {
                $query->where(function ($q) {
                    foreach ($this->selectedYears as $year) {
                        $yInt = (int)$year;
                        $q->orWhereYear('start_date', $yInt);
                        $q->orWhere('season', 'like', '%' . $yInt . '%')
                          ->orWhere('title', 'like', '%' . $yInt . '%')
                          ->orWhere('description', 'like', '%' . $yInt . '%');
                    }
                });
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

        $totalToursCount = (clone $toursQuery)->count();
        $tours = $toursQuery->latest()->paginate($this->perPage);

        $countries = Country::orderBy('name', 'asc')->get();

        // Tahun Berjalan & +1 Tahun
        $currentYear = (int)date('Y');
        $yearsList = [$currentYear, $currentYear + 1];

        return view('livewire.tour-schedule-page', [
            'tours'           => $tours,
            'totalToursCount' => $totalToursCount,
            'countries'       => $countries,
            'monthsList'      => $monthsList,
            'yearsList'       => $yearsList,
        ])->layout('components.layouts.app', [
            'title' => 'Jadwal Tour & Keberangkatan | TravelGo'
        ]);
    }
}
