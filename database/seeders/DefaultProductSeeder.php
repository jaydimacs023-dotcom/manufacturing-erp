<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DefaultProductSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $rawCategoryId = DB::table('product_categories')->where('category_code', 'RAW')->value('id');
        $fgCategoryId = DB::table('product_categories')->where('category_code', 'FG')->value('id');
        $pkgCategoryId = DB::table('product_categories')->where('category_code', 'PKG')->value('id');
        $kgUomId = DB::table('units_of_measure')->where('uom_code', 'kg')->value('id');
        $gUomId = DB::table('units_of_measure')->where('uom_code', 'g')->value('id');
        $pcUomId = DB::table('units_of_measure')->where('uom_code', 'pc')->value('id');
        $packUomId = DB::table('units_of_measure')->where('uom_code', 'pack')->value('id');
        $cartonUomId = DB::table('units_of_measure')->where('uom_code', 'carton')->value('id');

        $products = [
            // Raw Materials
            [
                'product_code' => 'RM-001',
                'product_name' => 'Saba Banana',
                'product_type' => 'raw_material',
                'category_id' => $rawCategoryId,
                'default_uom_id' => $kgUomId,
                'description' => 'Fresh Saba bananas for chips production',
                'shelf_life_days' => 7,
            ],
            [
                'product_code' => 'RM-002',
                'product_name' => 'Cooking Oil',
                'product_type' => 'raw_material',
                'category_id' => $rawCategoryId,
                'default_uom_id' => $gUomId,
                'description' => 'Vegetable oil for deep frying',
                'shelf_life_days' => 365,
            ],
            [
                'product_code' => 'RM-003',
                'product_name' => 'Salt',
                'product_type' => 'raw_material',
                'category_id' => $rawCategoryId,
                'default_uom_id' => $kgUomId,
                'description' => 'Fine salt for seasoning',
                'shelf_life_days' => 730,
            ],
            // Finished Goods
            [
                'product_code' => 'FG-001',
                'product_name' => 'Original Banana Chips 100g',
                'product_type' => 'finished_good',
                'category_id' => $fgCategoryId,
                'default_uom_id' => $packUomId,
                'description' => 'Classic salted banana chips in 100g pack',
                'shelf_life_days' => 180,
            ],
            [
                'product_code' => 'FG-002',
                'product_name' => 'BBQ Banana Chips 100g',
                'product_type' => 'finished_good',
                'category_id' => $fgCategoryId,
                'default_uom_id' => $packUomId,
                'description' => 'BBQ flavored banana chips in 100g pack',
                'shelf_life_days' => 180,
            ],
            [
                'product_code' => 'FG-003',
                'product_name' => 'Cheese Banana Chips 200g',
                'product_type' => 'finished_good',
                'category_id' => $fgCategoryId,
                'default_uom_id' => $packUomId,
                'description' => 'Cheese flavored banana chips in 200g pack',
                'shelf_life_days' => 180,
            ],
            // Packaging Materials
            [
                'product_code' => 'PKG-001',
                'product_name' => 'Plastic Bag 100g',
                'product_type' => 'packaging',
                'category_id' => $pkgCategoryId,
                'default_uom_id' => $pcUomId,
                'description' => 'Plastic packaging bag for 100g packs',
            ],
            [
                'product_code' => 'PKG-002',
                'product_name' => 'Master Carton',
                'product_type' => 'packaging',
                'category_id' => $pkgCategoryId,
                'default_uom_id' => $cartonUomId,
                'description' => 'Corrugated carton for shipping 50 packs',
            ],
        ];

        foreach ($products as $product) {
            DB::table('products')->updateOrInsert(
                ['product_code' => $product['product_code']],
                [
                    'uuid' => (string) Str::uuid(),
                    'product_name' => $product['product_name'],
                    'product_type' => $product['product_type'],
                    'category_id' => $product['category_id'],
                    'default_uom_id' => $product['default_uom_id'],
                    'description' => $product['description'],
                    'shelf_life_days' => $product['shelf_life_days'] ?? null,
                    'is_active' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }
}

