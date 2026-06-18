<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Appwrite seed data is handled via php artisan appwrite:seed command
        // $this->call([
        //     CountrySeeder::class,
        //     DestinationSeeder::class,
        //     TripSeeder::class,
        //     TestimonialSeeder::class,
        //     AdminSeeder::class,
        //     SettingSeeder::class,
        // ]);
    }
}
