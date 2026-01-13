<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'woodsketch@gmail.com'],
            [
                'name' => 'Omar Al-Tawil',
                'password' => Hash::make('Admin12345!'),
            ]
        );
    }
}
