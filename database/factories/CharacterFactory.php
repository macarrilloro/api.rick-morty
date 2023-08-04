<?php

namespace Database\Factories;

use App\Models\Character;
use App\Models\Location;
use App\Models\Origin;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Character>
 */
class CharacterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->word(20);
        return [
            'name' => $name,
            'status' => $this->faker->randomElement([Character::ALIVE, Character::DEAD, Character::UNKNOWN]),
            'species' => $this->faker->word(10),
            'type' => $this->faker->word(10),
            'gender' => $this->faker->word(10),
            'slug' => Str::slug($name),
            'location_id' => Location::all()->random()->id,
            'user_id' => User::all()->random()->id,
        ];
    }
}
