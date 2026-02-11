<?php

namespace Database\Factories;

use App\Models\RawMaterial;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

class BatchFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'raw_material_id' => RawMaterial::factory(),
            'warehouse_id' => Warehouse::factory(),
            'lot_number' => fake()->word(),
            'quantity' => fake()->randomFloat(2, 0, 99999999.99),
            'expiry_date' => fake()->date(),
            'received_date' => fake()->date(),
            'status' => fake()->word(),
            'notes' => fake()->text(),
        ];
    }
}
