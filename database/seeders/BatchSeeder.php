<?php

namespace Database\Seeders;

use App\Enums\BatchStatus;
use App\Models\Batch;
use App\Models\RawMaterial;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class BatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rawMaterials = RawMaterial::all();
        $warehouses = Warehouse::where('is_active', true)->get();

        if ($rawMaterials->isEmpty() || $warehouses->isEmpty()) {
            return;
        }

        foreach ($rawMaterials as $material) {
            // 1. Active Batch (Fresh)
            Batch::factory()->create([
                'raw_material_id' => $material->id,
                'warehouse_id' => $warehouses->random()->id,
                'quantity' => 100,
                'received_date' => now()->subDays(5),
                'expiry_date' => now()->addMonths(6),
                'status' => BatchStatus::Active,
                'notes' => 'دفعة جديدة - استلام ' . now()->subDays(5)->format('Y-m-d'),
            ]);

            // 2. Active Batch (Expiring Soon)
            Batch::factory()->create([
                'raw_material_id' => $material->id,
                'warehouse_id' => $warehouses->random()->id,
                'quantity' => 50,
                'received_date' => now()->subMonths(5),
                'expiry_date' => now()->addDays(5), // Expiring in 5 days
                'status' => BatchStatus::Active,
                'notes' => 'تنبيه: تنتهي الصلاحية قريباً',
            ]);

            // 3. Expired Batch
            Batch::factory()->create([
                'raw_material_id' => $material->id,
                'warehouse_id' => $warehouses->random()->id,
                'quantity' => 20,
                'received_date' => now()->subYear(),
                'expiry_date' => now()->subDays(10), // Expired
                'status' => BatchStatus::Expired,
                'notes' => 'منتهي الصلاحية - يجب الإتلاف',
            ]);
        }
        
        // 4. Batch without expiry (e.g. Salt/Sugar if applicable, though we seeded them as expiring for demo)
        // Let's verify null expiry support
         Batch::factory()->create([
            'raw_material_id' => $rawMaterials->first()->id,
            'warehouse_id' => $warehouses->first()->id,
            'quantity' => 200,
            'received_date' => now()->subMonth(),
            'expiry_date' => null,
            'status' => BatchStatus::Active,
            'notes' => 'لا يوجد تاريخ انتهاء (صلاحية مفتوحة)',
            'lot_number' => 'NO-EXP-' . rand(1000, 9999), 
        ]);
    }
}
