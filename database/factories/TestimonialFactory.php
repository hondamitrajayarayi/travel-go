<?php

namespace Database\Factories;

use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Factories\Factory;

class TestimonialFactory extends Factory
{
    protected $model = Testimonial::class;

    public function definition(): array
    {
        return [
            'name'       => $this->faker->name(),
            'tour_title' => $this->faker->randomElement([
                'Favorite Autumn in China (Beijing & Shanghai)',
                'Japan Golden Route & Mt. Fuji Experience',
                'Magical Turkey & Hot Air Balloon Cappadocia',
                'Autumn in Korea & Nami Island Romance',
                'West Europe Highlights 7 Countries',
            ]),
            'trip_date'  => $this->faker->randomElement(['Oktober 2026', 'September 2026', 'Agustus 2026', 'Juli 2026']),
            'story'      => $this->faker->paragraph(3),
            'rating'     => 5,
            'avatar'     => null,
            'photo'      => null,
            'is_active'  => true,
            'sort_order' => $this->faker->numberBetween(1, 10),
        ];
    }
}
