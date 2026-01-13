<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        $title = $this->faker->unique()->words(3, true);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'category_id' => Category::factory(),
            'short_description' => $this->faker->sentence(10),
            'description' => $this->faker->paragraphs(3, true),
            'cover_image' => 'images/projects/placeholder-cover.jpg',
            'gallery_images' => [
                'images/projects/gallery-1.jpg',
                'images/projects/gallery-2.jpg',
                'images/projects/gallery-3.jpg',
            ],
            'video_url' => $this->faker->boolean(30) ? $this->faker->url() : null,
            'video_file' => null,
            'before_image' => null,
            'after_image' => null,
            'location_text' => $this->faker->city() . ', UK',
            'completion_date' => $this->faker->boolean(70) ? $this->faker->date() : null,
            'tags' => $this->faker->words(3),
            'is_featured' => $this->faker->boolean(30),
            'status' => $this->faker->randomElement(['draft', 'published']),
        ];
    }
}
