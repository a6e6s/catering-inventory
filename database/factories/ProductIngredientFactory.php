<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\RawMaterial;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductIngredientFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'raw_material_id' => RawMaterial::factory(),
            'quantity_required' => fake()->randomFloat(2, 0, 99999999.99),
            'unit' => fake()->word(),
        ];
    }
}
