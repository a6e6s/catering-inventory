<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class WarehouseFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->city() . ' Warehouse',
            'type' => fake()->randomElement(\App\Enums\WarehouseType::cases()),
            'location' => fake()->address(),
            'capacity' => fake()->numberBetween(1000, 10000),
            'is_active' => true,
        ];
    }

    public function main(): static
    {
        return $this->state(fn(array $attributes) => [
            'name' => 'Main Central Warehouse',
            'type' => \App\Enums\WarehouseType::Main,
            'capacity' => 50000,
        ]);
    }

    public function association(): static
    {
        return $this->state(fn(array $attributes) => [
            'type' => \App\Enums\WarehouseType::Association,
            'capacity' => 5000,
        ]);
    }

    public function distributionPoint(): static
    {
        return $this->state(fn(array $attributes) => [
            'type' => \App\Enums\WarehouseType::DistributionPoint,
            'capacity' => 1000,
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => false,
        ]);
    }
}
