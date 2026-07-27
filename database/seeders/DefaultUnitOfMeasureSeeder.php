<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DefaultUnitOfMeasureSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $uoms = [
            ['uom_code' => 'kg', 'uom_name' => 'Kilogram', 'uom_type' => 'reference'],
            ['uom_code' => 'g', 'uom_name' => 'Gram', 'uom_type' => 'reference'],
            ['uom_code' => 'L', 'uom_name' => 'Liter', 'uom_type' => 'reference'],
            ['uom_code' => 'ml', 'uom_name' => 'Milliliter', 'uom_type' => 'reference'],
            ['uom_code' => 'pc', 'uom_name' => 'Piece', 'uom_type' => 'transactional'],
            ['uom_code' => 'pack', 'uom_name' => 'Pack', 'uom_type' => 'transactional'],
            ['uom_code' => 'box', 'uom_name' => 'Box', 'uom_type' => 'transactional'],
            ['uom_code' => 'carton', 'uom_name' => 'Carton', 'uom_type' => 'transactional'],
        ];

        foreach ($uoms as $uom) {
            DB::table('units_of_measure')->updateOrInsert(
                ['uom_code' => $uom['uom_code']],
                [
                    'uuid' => (string) Str::uuid(),
                    'uom_name' => $uom['uom_name'],
                    'uom_type' => $uom['uom_type'],
                    'is_active' => true,
                    'created_by' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }
}

