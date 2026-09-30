<?php

namespace App\Livewire;

use App\Models\Country;
use App\Models\Gallery;
use Livewire\Component;

class GalleryPage extends Component
{
    public function render()
    {
        $countries = Country::query()
            ->where('is_active', true)
            ->with(['galleries' => function ($query) {
                $query->where('is_active', true)
                      ->orderBy('is_featured', 'desc')
                      ->latest();
            }])
            ->whereHas('galleries', function ($query) {
                $query->where('is_active', true);
            })
            ->orderBy('name', 'asc')
            ->get();

        $totalCountries = $countries->count();
        $totalGalleries = Gallery::where('is_active', true)->count();

        // Hitung total foto
        $allGalleries = Gallery::where('is_active', true)->get(['image_path', 'images']);
        $totalPhotos = 0;
        foreach ($allGalleries as $g) {
            $count = count($g->getAllPhotos());
            $totalPhotos += ($count > 0 ? $count : 1);
        }

        return view('livewire.gallery-page', [
            'countries'      => $countries,
            'totalCountries' => $totalCountries,
            'totalGalleries' => $totalGalleries,
            'totalPhotos'    => $totalPhotos,
        ])->layout('components.layouts.app', [
            'title' => 'Galeri & Dokumentasi Perjalanan | Super Vacation'
        ]);
    }
}
