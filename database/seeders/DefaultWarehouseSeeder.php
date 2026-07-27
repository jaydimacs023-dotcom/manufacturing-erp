<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Administration\Models\Warehouse;

class DefaultWarehouseSeeder extends Seeder
{
    public function run(): void
    {
        $warehouses = [
            [
                'warehouse_name' => 'Raw Material Warehouse',
                'warehouse_code' => 'WH-RM',
                'warehouse_type' => 'raw_material',
                'address' => '123 Industrial Park, Manufacturing Zone',
                'is_active' => true,
                'branch_id' => 1,
            ],
            [
                'warehouse_name' => 'Packaging Warehouse',
                'warehouse_code' => 'WH-PKG',
                'warehouse_type' => 'packaging',
                'address' => '123 Industrial Park, Manufacturing Zone',
                'is_active' => true,
                'branch_id' => 1,
            ],
            [
                'warehouse_name' => 'Finished Goods Warehouse',
                'warehouse_code' => 'WH-FG',
                'warehouse_type' => 'finished_goods',
                'address' => '123 Industrial Park, Manufacturing Zone',
                'is_active' => true,
                'branch_id' => 1,
            ],
            [
                'warehouse_name' => 'Quarantine Warehouse',
                'warehouse_code' => 'WH-QC',
                'warehouse_type' => 'transit',
                'address' => '123 Industrial Park, Manufacturing Zone',
                'is_active' => true,
                'branch_id' => 1,
            ],
        ];

        foreach ($warehouses as $warehouse) {
            Warehouse::firstOrCreate(
                ['warehouse_code' => $warehouse['warehouse_code']],
                $warehouse
            );
        }
    }
}
