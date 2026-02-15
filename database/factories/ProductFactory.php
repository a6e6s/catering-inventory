<?php

namespace Database\Factories;

use App\Enums\ProductUnit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->words(3, true),
            'unit' => $this->faker->randomElement(ProductUnit::cases()),
            'description' => $this->faker->sentence(),
            'preparation_time' => $this->faker->numberBetween(10, 120),
            'is_active' => true,
        ];
    }
}
