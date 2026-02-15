<?php

namespace Database\Seeders;

use App\Enums\ProductUnit;
use App\Models\Product;
use App\Models\RawMaterial;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure we have raw materials
        if (RawMaterial::count() == 0) {
            $this->call(RawMaterialSeeder::class);
        }

        $rice = RawMaterial::where('name', 'like', '%أرز%')->first();
        $chicken = RawMaterial::where('name', 'like', '%دجاج%')->first();
        $oil = RawMaterial::where('name', 'like', '%زيت%')->first();
        $spices = RawMaterial::where('name', 'like', '%بهارات%')->first();

        // 1. Kabsa Meal
        $kabsa = Product::create([
            'name' => 'وجبة كبسة دجاج',
            'unit' => ProductUnit::MealPack,
            'description' => 'وجبة فردية تحتوي على نصف دجاجة وأرز',
            'preparation_time' => 45,
            'is_active' => true,
        ]);

        if ($rice) $kabsa->rawMaterials()->attach($rice->id, ['quantity_required' => 0.25, 'unit' => 'kg']);
        if ($chicken) $kabsa->rawMaterials()->attach($chicken->id, ['quantity_required' => 0.5, 'unit' => 'sadia 1000g']);
        if ($oil) $kabsa->rawMaterials()->attach($oil->id, ['quantity_required' => 0.05, 'unit' => 'liter']);
        if ($spices) $kabsa->rawMaterials()->attach($spices->id, ['quantity_required' => 0.01, 'unit' => 'kg']);

        // 2. Large Tray (5 Persons)
        $tray = Product::create([
            'name' => 'صينية كبسة عائلية',
            'unit' => ProductUnit::Tray,
            'description' => 'تكفي 5 أشخاص',
            'preparation_time' => 60,
            'is_active' => true,
        ]);

        if ($rice) $tray->rawMaterials()->attach($rice->id, ['quantity_required' => 1.5, 'unit' => 'kg']);
        if ($chicken) $tray->rawMaterials()->attach($chicken->id, ['quantity_required' => 3, 'unit' => 'whole']);
    }
}
