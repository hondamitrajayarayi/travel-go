<?php

namespace App\Livewire;

use App\Models\Tour;
use Livewire\Component;

class TourDetailPage extends Component
{
    public Tour $tour;
    public string $activeTab = 'itinerary'; // 'overview', 'itinerary', 'facilities', 'gallery'

    public function mount(string $slug)
    {
        $this->tour = Tour::with(['country', 'itineraries', 'facilities', 'galleries'])
            ->where('slug', $slug)
            ->firstOrFail();
    }

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        $relatedTours = Tour::where('id', '!=', $this->tour->id)
            ->where(function ($q) {
                if ($this->tour->country_id) {
                    $q->where('country_id', $this->tour->country_id);
                } else {
                    $q->where('destination', 'like', '%' . $this->tour->destination . '%');
                }
            })
            ->latest()
            ->take(3)
            ->get();

        if ($relatedTours->count() < 3) {
            $extra = Tour::where('id', '!=', $this->tour->id)
                ->whereNotIn('id', $relatedTours->pluck('id'))
                ->latest()
                ->take(3 - $relatedTours->count())
                ->get();
            $relatedTours = $relatedTours->merge($extra);
        }

        return view('livewire.tour-detail-page', [
            'relatedTours' => $relatedTours,
        ])->layout('components.layouts.app', [
            'title'           => ($this->tour->meta_title ?: $this->tour->title) . ' | Super Vacation',
            'metaDescription' => $this->tour->meta_description
                                    ?: strip_tags(substr($this->tour->description ?? '', 0, 160)),
            'metaKeywords'    => $this->tour->meta_keywords,
            'ogTitle'         => $this->tour->meta_title ?: $this->tour->title,
            'ogDescription'   => $this->tour->meta_description
                                    ?: strip_tags(substr($this->tour->description ?? '', 0, 160)),
            'ogImage'         => $this->tour->og_image
                                    ?: ($this->tour->thumbnail ? asset('storage/' . $this->tour->thumbnail) : null),
        ]);
    }
}
