<?php

namespace Database\Seeders;

use App\Models\RawMaterial;
use Illuminate\Database\Seeder;

class RawMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $materials = [
            [
                'name' => 'أرز بسمتي (طويل الحبة)',
                'unit' => 'كجم',
                'min_stock_level' => 100,
                'description' => 'أرز بسمتي عالي الجودة للوجبات الرئيسية.',
            ],
            [
                'name' => 'دجاج مجمد (كامل)',
                'unit' => 'كرتون',
                'min_stock_level' => 50,
                'description' => 'كرتون دجاج مجمد 10 × 1000 جم.',
            ],
            [
                'name' => 'زيت نباتي',
                'unit' => 'لتر',
                'min_stock_level' => 200,
                'description' => 'زيت للقلي والطبخ.',
            ],
            [
                'name' => 'سكر أبيض',
                'unit' => 'كيس',
                'min_stock_level' => 30,
                'description' => 'كيس سكر 50 كجم.',
            ],
            [
                'name' => 'طماطم معلبة',
                'unit' => 'كرتون',
                'min_stock_level' => 40,
                'description' => 'معجون طماطم عبوات 5 كجم.',
            ],
             [
                'name' => 'بهارات مشكلة',
                'unit' => 'كجم',
                'min_stock_level' => 10,
                'description' => 'خليط بهارات سعودية.',
            ],
        ];

        foreach ($materials as $material) {
            RawMaterial::create($material + ['is_active' => true]);
        }
    }
}
