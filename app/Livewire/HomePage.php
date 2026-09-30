<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\Banner;
use App\Models\Country;
use App\Models\Testimonial;
use App\Models\Tour;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class HomePage extends Component
{
    public string $search = '';
    public string $selectedCategory = 'all'; // 'all', 'open_trip', 'private_trip'
    public string $selectedDestination = 'all';
    public string $selectedCountry = 'all';
    public string $selectedMonth = 'all';
    public array $selectedMonths = [];
    public array $selectedYears = [];
    public int $limit = 6;

    public function selectCategory(string $category): void
    {
        $this->selectedCategory = $category;
    }

    public function showAllTours(): void
    {
        $this->limit = 999;
    }

    public function showLessTours(): void
    {
        $this->limit = 6;
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
        $this->limit = 6;
    }

    public function searchTours(): mixed
    {
        $params = [];
        if ($this->selectedCountry !== 'all' && !empty($this->selectedCountry)) {
            $params['selectedCountry'] = $this->selectedCountry;
        }
        if ($this->selectedMonth !== 'all' && !empty($this->selectedMonth)) {
            $params['selectedMonth'] = $this->selectedMonth;
        }

        return $this->redirectRoute('tour-schedule', $params, navigate: true);
    }

    public function render()
    {
        $banners = Banner::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->latest()
            ->get();

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
            ->when($this->selectedMonth !== 'all', function ($query) use ($monthsList) {
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
        $tours = $toursQuery->latest()->take($this->limit)->get();

        // Ambil daftar destinasi unik untuk Hero section
        $destinations = Tour::select('destination')
            ->distinct()
            ->pluck('destination');

        $countries = Country::orderBy('name', 'asc')->get();

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

        // Tahun Berjalan & +1 Tahun
        $currentYear = (int)date('Y');
        $yearsList = [$currentYear, $currentYear + 1];

        $testimonials = Testimonial::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->latest()
            ->take(10)
            ->get();

        $articles = Article::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        // Ambil 6 destinasi populer (Highlight / featured aktif)
        $popularDestinations = Country::where('is_active', true)
            ->whereHas('galleries', function ($q) {
                $q->where('is_featured', true)
                  ->where('is_active', true);
            })
            ->with(['galleries' => function ($q) {
                $q->where('is_active', true)
                  ->orderBy('is_featured', 'desc');
            }])
            ->take(6)
            ->get();

        if ($popularDestinations->count() < 6) {
            $additional = Country::where('is_active', true)
                ->whereNotIn('id', $popularDestinations->pluck('id'))
                ->with(['galleries' => function ($q) {
                    $q->where('is_active', true)
                      ->orderBy('is_featured', 'desc');
                }])
                ->take(6 - $popularDestinations->count())
                ->get();

            $popularDestinations = $popularDestinations->concat($additional);
        }

        return view('livewire.home-page', [
            'banners'             => $banners,
            'tours'               => $tours,
            'totalToursCount'     => $totalToursCount,
            'destinations'        => $destinations,
            'countries'           => $countries,
            'months'              => $months,
            'monthsList'          => $monthsList,
            'yearsList'           => $yearsList,
            'testimonials'        => $testimonials,
            'articles'            => $articles,
            'popularDestinations' => $popularDestinations,
        ]);
    }
}
