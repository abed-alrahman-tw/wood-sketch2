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
            'customer_name' => $this->faker->name(),
            'area' => $this->faker->boolean(70) ? $this->faker->city() : null,
            'rating' => $this->faker->numberBetween(4, 5),
            'content' => $this->faker->paragraph(2),
            'is_published' => $this->faker->boolean(80),
        ];
    }
}
