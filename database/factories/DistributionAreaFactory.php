<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DistributionAreaFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'location' => fake()->word(),
            'contact_person' => fake()->word(),
            'contact_phone' => fake()->word(),
            'is_active' => fake()->boolean(),
        ];
    }
}
