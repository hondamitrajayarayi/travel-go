<?php

namespace Database\Seeders;

use App\Models\Tour;
use App\Models\TourFacility;
use App\Models\TourGallery;
use App\Models\TourItinerary;
use Illuminate\Database\Seeder;

class TourSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat 5 paket Tour beserta relasi itinerary, facility, dan gallery
        Tour::factory()
            ->count(5)
            ->create()
            ->each(function (Tour $tour) {
                // Generate Itinerary (3 Hari)
                for ($day = 1; $day <= 3; $day++) {
                    TourItinerary::factory()->create([
                        'tour_id'    => $tour->id,
                        'day_number' => $day,
                        'title'      => "Eksplorasi Hari Ke-$day",
                    ]);
                }

                // Generate Include Facilities
                TourFacility::factory()->count(4)->create([
                    'tour_id' => $tour->id,
                    'type'    => 'include',
                ]);

                // Generate Exclude Facilities
                TourFacility::factory()->count(2)->create([
                    'tour_id' => $tour->id,
                    'type'    => 'exclude',
                ]);

                // Generate Galleries
                TourGallery::factory()->count(3)->create([
                    'tour_id' => $tour->id,
                ]);
            });
    }
}
