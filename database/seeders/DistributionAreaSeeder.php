<?php

namespace Database\Seeders;

use App\Models\DistributionArea;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class DistributionAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure there are warehouses to attach to
        if (Warehouse::count() === 0) {
            Warehouse::factory(3)->create();
        }

        $warehouses = Warehouse::all();

        DistributionArea::factory(10)->create()->each(function ($area) use ($warehouses) {
            // Attach to 1-2 random warehouses
            $area->warehouses()->attach(
                $warehouses->random(rand(1, 2))->pluck('id')->toArray()
            );
        });
    }
}
