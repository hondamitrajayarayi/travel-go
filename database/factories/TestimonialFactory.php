<?php

namespace Database\Factories;

use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Factories\Factory;

class TestimonialFactory extends Factory
{
    protected $model = Testimonial::class;

    public function definition(): array
    {
        $platform = $this->faker->randomElement(['youtube_short', 'instagram']);

        return [
            'title'     => $this->faker->sentence(4),
            'platform'  => $platform,
            'embed_url' => $platform === 'youtube_short'
                ? 'https://www.youtube.com/embed/' . $this->faker->regexify('[A-Za-z0-9_-]{11}')
                : 'https://www.instagram.com/p/' . $this->faker->regexify('[A-Za-z0-9_-]{10}') . '/embed',
            'is_active' => true,
        ];
    }
}
