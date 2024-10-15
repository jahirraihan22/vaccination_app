<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VaccineCenter>
 */
class VaccineCenterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->city(),  // Random center name
            'location' => $this->faker->address, // Random address
            'daily_limit' => $this->faker->numberBetween(50, 200), // Capacity between 50 and 500 users
        ];
    }
}
