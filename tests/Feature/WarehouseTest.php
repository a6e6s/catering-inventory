<?php

namespace Tests\Feature;

use App\Enums\WarehouseType;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WarehouseTest extends TestCase
{
    use RefreshDatabase;

    public function test_main_warehouse_cannot_be_deleted()
    {
        $mainWarehouse = Warehouse::factory()->main()->create();
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin);

        try {
            $mainWarehouse->delete();
            $this->fail('Should have thrown exception');
        } catch (\Exception $e) {
            $this->assertEquals(__('warehouse.messages.main_warehouse_delete_error'), $e->getMessage());
        }

        $this->assertModelExists($mainWarehouse);
    }

    public function test_type_restrictions_logic()
    {
        $main = Warehouse::factory()->main()->create();
        $assoc = Warehouse::factory()->association()->create();
        $dist = Warehouse::factory()->distributionPoint()->create();

        // Main can send to Association -> TRUE
        $this->assertTrue($assoc->canReceiveFrom($main));

        // Main can send to Distribution -> TRUE
        $this->assertTrue($dist->canReceiveFrom($main));

        // Association can send to Distribution -> TRUE
        $this->assertTrue($dist->canReceiveFrom($assoc));

        // Distribution CANNOT send to Association -> FALSE
        $this->assertFalse($assoc->canReceiveFrom($dist));

        // Association CANNOT receive from another Association -> FALSE
        $otherAssoc = Warehouse::factory()->association()->create();
        $this->assertFalse($assoc->canReceiveFrom($otherAssoc));
    }

    public function test_capacity_checks()
    {
        $warehouse = Warehouse::factory()->create(['capacity' => 100]);
        // Mock current stock to be 0 (since factory doesn't create products)
        // We can't easily mock the 'currentStock' method on the model without partial mocks, 
        // effectively tested by logic: (0 + 50) <= 100

        $this->assertTrue($warehouse->hasCapacityFor(50));
        $this->assertTrue($warehouse->hasCapacityFor(100));
        $this->assertFalse($warehouse->hasCapacityFor(101));
    }
}
