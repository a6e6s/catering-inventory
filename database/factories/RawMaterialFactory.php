<?php

namespace Database\Factories;

use App\Enums\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RawMaterial>
 */
class RawMaterialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Raw Material ' . $this->faker->unique()->word,
            'unit' => $this->faker->randomElement(Unit::cases()),
            'description' => $this->faker->sentence,
            'min_stock_level' => $this->faker->numberBetween(10, 100),
            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    public function lowStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'min_stock_level' => 1000, // Likely higher than current stock
        ]);
    }
}
