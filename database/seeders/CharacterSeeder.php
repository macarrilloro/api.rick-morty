<?php

namespace Database\Seeders;

use App\Models\Character;
use App\Models\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CharacterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Character::factory(100)->create()->each(function(Character $character){
            Image::factory(1)->create([
                'imageable_id' => $character->id,
                'imageable_type' => Character::class
            ]);

            $character->episodes()->attach([
                rand(1,4),
                rand(5,8)
            ]);
            $character->locations()->attach([
                rand(1,4),
                rand(5,8) 
            ]);
        });
    }
}
