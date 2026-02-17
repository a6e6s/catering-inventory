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

        $saudiAreas = [
            ['name' => 'الرياض - حي العليا', 'location' => 'الرياض', 'contact_person' => 'محمد سعيد', 'contact_phone' => '0501234567'],
            ['name' => 'الرياض - حي الملز', 'location' => 'الرياض', 'contact_person' => 'خالد عبد الرحمن', 'contact_phone' => '0501234568'],
            ['name' => 'جدة - حي الحمراء', 'location' => 'جدة', 'contact_person' => 'أحمد الغامدي', 'contact_phone' => '0501234569'],
            ['name' => 'جدة - حي الروضة', 'location' => 'جدة', 'contact_person' => 'سعيد الحربي', 'contact_phone' => '0501234570'],
            ['name' => 'الدمام - حي الشاطئ', 'location' => 'الدمام', 'contact_person' => 'فهد الدوسري', 'contact_phone' => '0501234571'],
            ['name' => 'مكة المكرمة - العزيزية', 'location' => 'مكة المكرمة', 'contact_person' => 'عبد الله القرشي', 'contact_phone' => '0501234572'],
            ['name' => 'المدينة المنورة - قباء', 'location' => 'المدينة المنورة', 'contact_person' => 'عمر الجهني', 'contact_phone' => '0501234573'],
            ['name' => 'الطائف - شهار', 'location' => 'الطائف', 'contact_person' => 'سلمان العتيبي', 'contact_phone' => '0501234574'],
            ['name' => 'الخبر - الحزام الذهبي', 'location' => 'الخبر', 'contact_person' => 'ماجد القحطاني', 'contact_phone' => '0501234575'],
            ['name' => 'أبها - حي الضباب', 'location' => 'أبها', 'contact_person' => 'ياسر الشهري', 'contact_phone' => '0501234576'],
        ];

        foreach ($saudiAreas as $areaData) {
            $area = DistributionArea::firstOrCreate(
                ['name' => $areaData['name']], // Check by name to avoid duplicates
                [
                    'location' => $areaData['location'],
                    'contact_person' => $areaData['contact_person'],
                    'contact_phone' => $areaData['contact_phone'],
                    'capacity' => rand(100, 500),
                    'distribution_frequency' => \App\Models\DistributionArea::FREQUENCIES['weekly'],
                    'is_active' => true,
                    'requires_photo_verification' => true,
                ]
            );

            // Attach to random warehouse if not already attached
            if ($area->warehouses()->count() === 0) {
                $area->warehouses()->attach(
                    $warehouses->random(rand(1, 2))->pluck('id')->toArray()
                );
            }
        }
    }
}
