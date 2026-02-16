<?php

namespace Database\Factories;

use App\Enums\DistributionRecordStatus;
use App\Models\DistributionArea;
use App\Models\DistributionRecord;
use App\Models\InventoryTransaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DistributionRecord>
 */
class DistributionRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'transaction_id' => InventoryTransaction::factory(),
            'distribution_area_id' => DistributionArea::factory(),
            'beneficiaries_served' => fake()->numberBetween(10, 500),
            'photos' => null,
            'status' => DistributionRecordStatus::Pending,
            'verified_by' => null,
            'verified_at' => null,
            'notes' => fake()->sentence(),
        ];
    }

    public function verified(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => DistributionRecordStatus::Verified,
            'verified_by' => User::factory(),
            'verified_at' => now(),
        ]);
    }

    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => DistributionRecordStatus::Rejected,
            'verified_by' => User::factory(),
            'verified_at' => now(),
            'rejection_reason' => fake()->sentence(),
        ]);
    }
}
