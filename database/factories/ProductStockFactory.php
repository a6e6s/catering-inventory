<?php

namespace Database\Factories;

use App\Models\Batch;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductStockFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'warehouse_id' => Warehouse::factory(),
            'batch_id' => Batch::factory(),
            'quantity' => fake()->randomFloat(2, 0, 99999999.99),
            'last_updated' => fake()->dateTime(),
        ];
    }
}
