<?php

namespace Database\Seeders;

use App\Enums\WarehouseType;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Main Warehouse
        Warehouse::factory()->create([
            'name' => 'المستودع الرئيسي - الرياض',
            'type' => WarehouseType::Main,
            'location' => 'المنطقة الصناعية، الرياض',
            'capacity' => 10000,
            'is_active' => true,
        ]);

        // 2. Association
        Warehouse::factory()->create([
            'name' => 'جمعية البركة الخيرية',
            'type' => WarehouseType::Association,
            'location' => 'حي الملز، الرياض',
            'capacity' => 5000,
            'is_active' => true,
        ]);

        // 3. Distribution Point
        Warehouse::factory()->create([
            'name' => 'نقطة توزيع - الشفاء',
            'type' => WarehouseType::DistributionPoint,
            'location' => 'حي الشفاء، الرياض',
            'capacity' => 2000,
            'is_active' => true,
        ]);
        
        // 4. Inactive Warehouse
        Warehouse::factory()->create([
            'name' => 'مستودع الصيانة (غير نشط)',
            'type' => WarehouseType::Main,
            'location' => 'المخازن القديمة',
            'capacity' => 1000,
            'is_active' => false,
        ]);
    }
}
