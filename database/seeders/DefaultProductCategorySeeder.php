<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DefaultProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $categories = [
            ['category_code' => 'RAW', 'category_name' => 'Raw Materials', 'description' => 'Raw materials used in production'],
            ['category_code' => 'FG', 'category_name' => 'Finished Goods', 'description' => 'Finished products ready for sale'],
            ['category_code' => 'PKG', 'category_name' => 'Packaging', 'description' => 'Packaging materials'],
            ['category_code' => 'CNS', 'category_name' => 'Consumables', 'description' => 'Consumable supplies'],
        ];

        foreach ($categories as $category) {
            DB::table('product_categories')->insert([
                'uuid' => (string) Str::uuid(),
                'category_code' => $category['category_code'],
                'category_name' => $category['category_name'],
                'description' => $category['description'],
                'is_active' => true,
                'created_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}

