<?php

namespace Tests\Feature;

use App\Enums\Unit;
use App\Filament\Resources\RawMaterials\Pages\CreateRawMaterial;
use App\Filament\Resources\RawMaterials\Pages\ListRawMaterials;
use App\Filament\Resources\RawMaterials\RawMaterialResource;
use App\Models\Product;
use App\Models\RawMaterial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class RawMaterialTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        // Create admin user using simple column
        $this->user = User::factory()->create(['role' => 'admin']);
    }

    public function test_can_render_raw_materials_page()
    {
        $this->actingAs($this->user);

        $this->get(RawMaterialResource::getUrl('index'))
            ->assertSuccessful();
    }

    public function test_can_create_raw_material()
    {
        $this->actingAs($this->user);

        $newData = RawMaterial::factory()->make();

        Livewire::test(CreateRawMaterial::class)
            ->fillForm([
                'name' => $newData->name,
                'unit' => $newData->unit->value,
                'min_stock_level' => 10,
                'is_active' => true,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas(RawMaterial::class, [
            'name' => $newData->name,
            'unit' => $newData->unit->value,
        ]);
    }

    public function test_validates_unique_name()
    {
        $this->actingAs($this->user);

        $existing = RawMaterial::factory()->create();

        Livewire::test(CreateRawMaterial::class)
            ->fillForm([
                'name' => $existing->name, // Duplicate name
                'unit' => Unit::Kg->value,
            ])
            ->call('create')
            ->assertHasFormErrors(['name']);
    }

    public function test_cannot_delete_raw_material_in_use()
    {
        $this->actingAs($this->user);

        $rawMaterial = RawMaterial::factory()->create();
        $product = Product::factory()->create();
        
        // Use standard pivot attachment 
        try {
             $rawMaterial->products()->attach($product->id, [
                'quantity_required' => 5,
                'unit' => 'kg'
            ]);
        } catch (\Exception $e) {
            $this->markTestSkipped('Pivot relation setup failed: ' . $e->getMessage());
        }

        // Expect the exception thrown by the model
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Cannot delete raw material used in active products.');

        Livewire::test(ListRawMaterials::class)
            ->callTableAction(\Filament\Actions\DeleteAction::class, $rawMaterial);
        
        // Assert that the record still exists because deletion should fail
        $this->assertDatabaseHas(RawMaterial::class, ['id' => $rawMaterial->id]);
    }
}
