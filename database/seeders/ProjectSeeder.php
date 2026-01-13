<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $categoryIds = Category::pluck('id')->all();

        $projects = [
            [
                'title' => 'Oak Reading Nook',
                'short_description' => 'Cosy built-in nook with floating shelves.',
                'before_image' => 'images/projects/before-reading-nook.jpg',
                'after_image' => 'images/projects/after-reading-nook.jpg',
            ],
            [
                'title' => 'Kitchen Pantry Upgrade',
                'short_description' => 'Soft-close pantry cabinetry with pull-outs.',
                'before_image' => 'images/projects/before-pantry.jpg',
                'after_image' => 'images/projects/after-pantry.jpg',
            ],
            [
                'title' => 'Elm Hallway Console',
                'short_description' => 'Slimline console with hidden storage.',
            ],
            [
                'title' => 'Garden Bench Restoration',
                'short_description' => 'Refinished bench with weatherproof oil.',
            ],
            [
                'title' => 'Loft Storage Build',
                'short_description' => 'Custom ladders and fitted loft cupboards.',
            ],
            [
                'title' => 'Birch Media Wall',
                'short_description' => 'Media wall with integrated cable management.',
            ],
        ];

        foreach ($projects as $project) {
            $title = $project['title'];

            Project::factory()->create([
                'title' => $title,
                'slug' => Str::slug($title),
                'category_id' => Arr::random($categoryIds),
                'short_description' => $project['short_description'],
                'before_image' => $project['before_image'] ?? null,
                'after_image' => $project['after_image'] ?? null,
                'status' => 'published',
                'is_featured' => true,
            ]);
        }
    }
}
