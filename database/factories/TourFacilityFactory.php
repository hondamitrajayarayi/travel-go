<?php

namespace Database\Factories;

use App\Models\Tour;
use App\Models\TourFacility;
use Illuminate\Database\Eloquent\Factories\Factory;

class TourFacilityFactory extends Factory
{
    protected $model = TourFacility::class;

    public function definition(): array
    {
        return [
            'tour_id'     => Tour::factory(),
            'type'        => $this->faker->randomElement(['include', 'exclude']),
            'description' => $this->faker->words(3, true),
        ];
    }
}
