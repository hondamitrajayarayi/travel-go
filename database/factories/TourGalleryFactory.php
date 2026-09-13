<?php

namespace Database\Factories;

use App\Models\Tour;
use App\Models\TourGallery;
use Illuminate\Database\Eloquent\Factories\Factory;

class TourGalleryFactory extends Factory
{
    protected $model = TourGallery::class;

    public function definition(): array
    {
        return [
            'tour_id'    => Tour::factory(),
            'image_path' => 'tours/galleries/' . $this->faker->uuid() . '.jpg',
        ];
    }
}
