<?php

namespace Tests\Feature;

use App\Models\DistributionArea;
use App\Models\User;
use App\Models\Warehouse;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DistributionAreaTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
    }

    public function test_slug_is_generated_on_create()
    {
        $area = DistributionArea::create([
            'name' => 'Saudi Food Bank',
            'location' => 'Riyadh',
            'capacity' => 500,
            'distribution_frequency' => 'daily',
            'is_active' => true,
        ]);

        $this->assertEquals('saudi-food-bank', $area->slug);
    }

    public function test_admin_can_update_area()
    {
        $user = User::factory()->create();
        $user->assignRole('admin'); // Assuming RoleSeeder works or using mock

        $area = DistributionArea::factory()->create();

        $this->assertTrue($user->can('update', $area));
    }

    public function test_regular_user_cannot_update_area()
    {
        $user = User::factory()->create(); // No role
        $area = DistributionArea::factory()->create();

        $this->assertFalse($user->can('update', $area));
    }

    public function test_can_assign_warehouses()
    {
        $warehouse = Warehouse::factory()->create();
        $area = DistributionArea::factory()->create();

        $area->warehouses()->attach($warehouse);

        $this->assertTrue($area->warehouses->contains($warehouse));
    }

    public function test_high_demand_scope()
    {
        $high = DistributionArea::factory()->create(['capacity' => 400]);
        $low = DistributionArea::factory()->create(['capacity' => 50]);

        $this->assertTrue(DistributionArea::highDemand()->where('id', $high->id)->exists());
        $this->assertFalse(DistributionArea::highDemand()->where('id', $low->id)->exists());
    }

    public function test_active_scope()
    {
        $active = DistributionArea::factory()->create(['is_active' => true]);
        $inactive = DistributionArea::factory()->create(['is_active' => false]);

        $this->assertTrue(DistributionArea::active()->where('id', $active->id)->exists());
        $this->assertFalse(DistributionArea::active()->where('id', $inactive->id)->exists());
    }
}
