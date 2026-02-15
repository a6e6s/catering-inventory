<?php

namespace Tests\Feature;

use App\Enums\ProductUnit;
use App\Models\Product;
use App\Models\RawMaterial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(['role' => 'admin']);
    }

    public function test_can_create_product()
    {
        $this->actingAs($this->user);

        $productData = [
            'name' => 'Kabsa Meal',
            'unit' => ProductUnit::MealPack,
            'description' => 'Traditional Saudi dish',
            'preparation_time' => 45,
            'is_active' => true,
        ];

        $product = Product::create($productData);

        $this->assertDatabaseHas('products', ['name' => 'Kabsa Meal']);
        $this->assertEquals(ProductUnit::MealPack, $product->unit);
    }

    public function test_can_attach_ingredients()
    {
        $this->actingAs($this->user);

        $product = Product::factory()->create();
        $rawMaterial = RawMaterial::factory()->create(['unit' => 'kg']);

        $product->rawMaterials()->attach($rawMaterial->id, [
            'quantity_required' => 0.5,
            'unit' => 'kg'
        ]);

        $this->assertDatabaseHas('product_ingredients', [
            'product_id' => $product->id,
            'raw_material_id' => $rawMaterial->id,
            'quantity_required' => 0.5
        ]);
        
        $this->assertEquals(1, $product->rawMaterials()->count());
    }

    public function test_active_scope()
    {
        Product::factory()->create(['is_active' => true]);
        Product::factory()->create(['is_active' => false]);

        $this->assertEquals(1, Product::active()->count());
    }
}
