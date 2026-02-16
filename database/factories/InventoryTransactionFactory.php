<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class InventoryTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'type' => fake()->randomElement(\App\Enums\InventoryTransactionType::cases()),
            'from_warehouse_id' => \App\Models\Warehouse::factory(),
            'to_warehouse_id' => \App\Models\Warehouse::factory(),
            'product_id' => \App\Models\Product::factory(),
            'batch_id' => \App\Models\Batch::factory(),
            'quantity' => fake()->randomFloat(2, 1, 1000),
            'status' => fake()->randomElement(\App\Enums\InventoryTransactionStatus::cases()),
            'initiated_by' => \App\Models\User::factory(),
            'notes' => fake()->text(),
            'transaction_date' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
