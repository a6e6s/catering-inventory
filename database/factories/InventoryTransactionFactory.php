<?php

namespace Database\Factories;

use App\Models\Batch;
use App\Models\FromWarehouse;
use App\Models\Product;
use App\Models\ToWarehouse;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class InventoryTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'type' => fake()->word(),
            'from_warehouse_id' => FromWarehouse::factory(),
            'to_warehouse_id' => ToWarehouse::factory(),
            'product_id' => Product::factory(),
            'batch_id' => Batch::factory(),
            'quantity' => fake()->randomFloat(2, 0, 99999999.99),
            'status' => fake()->word(),
            'initiated_by' => User::factory()->create()->initiated_by,
            'notes' => fake()->text(),
            'transaction_date' => fake()->dateTime(),
            'initiated_by_id' => User::factory(),
        ];
    }
}
