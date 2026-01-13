<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['name' => 'Custom cabinetry', 'price' => 450],
            ['name' => 'Staircase refurbishment', 'price' => 650],
            ['name' => 'Built-in wardrobes', 'price' => 900],
            ['name' => 'Solid wood shelving', 'price' => 280],
            ['name' => 'Garden gates & fencing', 'price' => 320],
            ['name' => 'Furniture restoration', 'price' => 200],
        ];

        foreach ($services as $service) {
            Service::create([
                'name' => $service['name'],
                'slug' => Str::slug($service['name']),
                'description' => 'Handcrafted woodworking service tailored to your space and style.',
                'starting_price' => $service['price'],
                'is_active' => true,
            ]);
        }
    }
}
