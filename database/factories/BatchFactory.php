<?php

namespace Database\Factories;

use App\Enums\BatchStatus;
use App\Models\Batch;
use App\Models\RawMaterial;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Batch>
 */
class BatchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'raw_material_id' => RawMaterial::factory(),
            'warehouse_id' => Warehouse::factory(),
            'lot_number' => 'LOT-' . fake()->unique()->numerify('#####'),
            'quantity' => fake()->randomFloat(2, 10, 500),
            'received_date' => fake()->dateTimeBetween('-3 months', 'now'),
            'expiry_date' => fake()->dateTimeBetween('+1 month', '+1 year'),
            'status' => BatchStatus::Active,
            'notes' => fake()->sentence(),
        ];
    }

    public function expired(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => BatchStatus::Expired,
            'expiry_date' => fake()->dateTimeBetween('-1 year', '-1 day'),
        ]);
    }

    public function quarantined(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => BatchStatus::Quarantined,
        ]);
    }

    public function expiringSoon(): static
    {
        return $this->state(fn (array $attributes) => [
            'expiry_date' => now()->addDays(3),
        ]);
    }
}
