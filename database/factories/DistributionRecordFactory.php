<?php

namespace Database\Factories;

use App\Models\DistributionArea;
use App\Models\InventoryTransaction;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DistributionRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'transaction_id' => Transaction::factory(),
            'distribution_area_id' => DistributionArea::factory(),
            'beneficiaries_served' => fake()->numberBetween(-10000, 10000),
            'photos' => '{}',
            'verified_by' => User::factory()->create()->verified_by,
            'verified_at' => fake()->dateTime(),
            'notes' => fake()->text(),
            'inventory_transaction_id' => InventoryTransaction::factory(),
            'verified_by_id' => User::factory(),
        ];
    }
}
