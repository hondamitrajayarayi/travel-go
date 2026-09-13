<?php

namespace Database\Factories;

use App\Models\Tour;
use App\Models\TourItinerary;
use Illuminate\Database\Eloquent\Factories\Factory;

class TourItineraryFactory extends Factory
{
    protected $model = TourItinerary::class;

    public function definition(): array
    {
        return [
            'tour_id'     => Tour::factory(),
            'day_number'  => $this->faker->numberBetween(1, 5),
            'title'       => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(2),
        ];
    }
}
