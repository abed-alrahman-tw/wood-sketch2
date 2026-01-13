<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        SiteSetting::create([
            'site_name' => 'WoodSketch',
            'owner_name' => 'Omar Al-Tawil',
            'city' => 'Steyning, UK',
            'email' => 'woodsketch@gmail.com',
            'phone' => null,
            'whatsapp' => null,
            'hero_title' => 'Handcrafted woodwork for distinctive homes',
            'hero_subtitle' => 'Bespoke joinery, thoughtful design, and meticulous finishes.',
            'service_radius_miles' => 20,
            'social_links' => [
                'instagram' => 'https://instagram.com/woodsketch',
                'facebook' => 'https://facebook.com/woodsketch',
            ],
            'google_reviews_url' => null,
        ]);
    }
}
