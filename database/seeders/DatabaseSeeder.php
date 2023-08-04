<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Episode;
use App\Models\Location;
use App\Models\Origin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Storage::makeDirectory('characters');
        $this->call(UserSeeder::class);
        // Location::factory(9)->create();
        // Episode::factory(9)->create();
        // $this->call(CharacterSeeder::class);
    }
}
