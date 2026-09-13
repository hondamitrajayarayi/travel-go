<?php

namespace Database\Factories;

use App\Models\Tour;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TourFactory extends Factory
{
    protected $model = Tour::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(4);

        return [
            'title'       => $title,
            'slug'        => Str::slug($title),
            'destination' => $this->faker->city() . ', Indonesia',
            'price'       => $this->faker->numberBetween(1500000, 7500000),
            'duration'    => $this->faker->randomElement(['3H2M', '4H3M', '5H4M', '2H1M']),
            'description' => $this->faker->paragraph(4),
            'thumbnail'   => 'tours/thumbnails/sample.jpg',
        ];
    }
}
