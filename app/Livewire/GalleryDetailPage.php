<?php

namespace App\Livewire;

use App\Models\Country;
use App\Models\Gallery;
use App\Models\Tour;
use Livewire\Component;

class GalleryDetailPage extends Component
{
    public Country $country;
    public string $activeTab = 'all'; // 'all' or specific gallery id

    public function mount(string $slug): void
    {
        $this->country = Country::where('slug', $slug)
            ->where('is_active', true)
            ->with(['galleries' => function ($query) {
                $query->where('is_active', true)
                      ->orderBy('is_featured', 'desc')
                      ->latest();
            }])
            ->firstOrFail();
    }

    public function render()
    {
        $galleries = $this->country->galleries;

        // Kumpulkan semua foto dengan metadata rapi
        $allPhotos = [];
        foreach ($galleries as $gallery) {
            $photos = $gallery->getAllPhotos();
            foreach ($photos as $idx => $photoPath) {
                $allPhotos[] = [
                    'id'          => $gallery->id . '-' . $idx,
                    'gallery_id'  => $gallery->id,
                    'title'       => $gallery->title,
                    'destination' => $gallery->destination ?: $this->country->name,
                    'image'       => asset('storage/' . $photoPath),
                    'is_featured' => (bool) $gallery->is_featured,
                ];
            }
        }

        // Ambil paket tour & jadwal keberangkatan terkait negara ini
        $countryName = $this->country->name;
        $relatedTours = Tour::query()
            ->where(function ($q) use ($countryName) {
                $q->where('country_id', $this->country->id)
                  ->orWhere('destination', 'like', '%' . $countryName . '%')
                  ->orWhere('title', 'like', '%' . $countryName . '%');
            })
            ->with(['departures' => function ($q) {
                $q->orderBy('start_date', 'asc');
            }])
            ->latest()
            ->get();

        // Destinasi / negara lainnya untuk navigasi cepat (1 baris 4 kartu)
        $otherCountries = Country::where('is_active', true)
            ->where('id', '!=', $this->country->id)
            ->has('galleries')
            ->orderBy('name', 'asc')
            ->take(4)
            ->get();

        return view('livewire.gallery-detail-page', [
            'country'        => $this->country,
            'galleries'      => $galleries,
            'allPhotos'      => $allPhotos,
            'relatedTours'   => $relatedTours,
            'otherCountries' => $otherCountries,
        ])->layout('components.layouts.app', [
            'title'          => 'Dokumentasi & Jadwal Tour ' . $this->country->name . ' | Super Vacation',
            'metaDescription'=> 'Lihat galeri dokumentasi autentik liburan dan jadwal keberangkatan tour ' . $this->country->name . ' bersama Super Vacation.',
        ]);
    }
}
