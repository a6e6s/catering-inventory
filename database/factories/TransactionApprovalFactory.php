<?php

namespace Database\Factories;

use App\Models\InventoryTransaction;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionApprovalFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'transaction_id' => Transaction::factory(),
            'approver_role' => fake()->word(),
            'approver_id' => User::factory(),
            'step' => fake()->numberBetween(-10000, 10000),
            'status' => fake()->word(),
            'comments' => fake()->text(),
            'approved_at' => fake()->dateTime(),
            'inventory_transaction_id' => InventoryTransaction::factory(),
        ];
    }
}
