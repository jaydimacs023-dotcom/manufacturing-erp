<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Manufacturing\Models\BillOfMaterial;
use Modules\Manufacturing\Models\BillOfMaterialItem;
use Modules\ProductMaster\Models\Product;

class DefaultBomSeeder extends Seeder
{
    public function run(): void
    {
        // Get or create a finished good product for Banana Chips
        $finishedGood = Product::where('product_type', 'finished_good')->first();
        if (!$finishedGood) {
            $this->command->warn('No finished good product found. Skipping BOM seeder.');
            return;
        }

        $rawMaterials = Product::where('product_type', 'raw_material')->get();
        $packaging = Product::where('product_type', 'packaging')->get();

        // Find specific products
        $banana = $rawMaterials->firstWhere('product_code', 'RAW-BANANA');
        $oil = $rawMaterials->firstWhere('product_code', 'RAW-OIL');
        $flavoring = $rawMaterials->firstWhere('product_code', 'RAW-FLAVOR');
        $bag = $packaging->firstWhere('product_code', 'PKG-BAG');
        $label = $packaging->firstWhere('product_code', 'PKG-LABEL');

        if (!$banana || !$oil) {
            $this->command->warn('Required raw materials not found. Skipping BOM seeder.');
            return;
        }

        // Create standard BOM for Banana Chips (100g pack)
        $bom = BillOfMaterial::create([
            'bom_number' => 'BOM-2026-000001',
            'product_id' => $finishedGood->id,
            'version' => '1.0',
            'effective_date' => now()->startOfYear(),
            'status' => 'approved',
            'total_quantity' => 1,
            'uom_id' => $finishedGood->default_uom_id,
            'description' => 'Standard Bill of Materials for 100g Banana Chips Pack',
            'is_active' => true,
        ]);

        // BOM Items (quantities per 1 unit of finished good)
        $items = [
            [
                'bill_of_material_id' => $bom->id,
                'product_id' => $banana->id,
                'uom_id' => $banana->default_uom_id,
                'quantity' => 1.2, // 1.2 kg raw banana for 1 pack
                'waste_percentage' => 15.0, // 15% waste from peeling
                'unit_cost' => 0.50,
                'total_cost' => 0.60,
                'is_active' => true,
                'remarks' => 'Raw saba bananas',
            ],
            [
                'bill_of_material_id' => $bom->id,
                'product_id' => $oil->id,
                'uom_id' => $oil->default_uom_id,
                'quantity' => 0.1, // 0.1 L cooking oil
                'waste_percentage' => 5.0,
                'unit_cost' => 1.50,
                'total_cost' => 0.15,
                'is_active' => true,
                'remarks' => 'Cooking oil for frying',
            ],
        ];

        if ($flavoring) {
            $items[] = [
                'bill_of_material_id' => $bom->id,
                'product_id' => $flavoring->id,
                'uom_id' => $flavoring->default_uom_id,
                'quantity' => 0.01,
                'waste_percentage' => 0,
                'unit_cost' => 2.00,
                'total_cost' => 0.02,
                'is_active' => true,
                'remarks' => 'Flavoring seasoning',
            ];
        }

        if ($bag) {
            $items[] = [
                'bill_of_material_id' => $bom->id,
                'product_id' => $bag->id,
                'uom_id' => $bag->default_uom_id,
                'quantity' => 1,
                'waste_percentage' => 2.0,
                'unit_cost' => 0.10,
                'total_cost' => 0.10,
                'is_active' => true,
                'remarks' => '100g packaging bag',
            ];
        }

        if ($label) {
            $items[] = [
                'bill_of_material_id' => $bom->id,
                'product_id' => $label->id,
                'uom_id' => $label->default_uom_id,
                'quantity' => 1,
                'waste_percentage' => 1.0,
                'unit_cost' => 0.05,
                'total_cost' => 0.05,
                'is_active' => true,
                'remarks' => 'Product label',
            ];
        }

        foreach ($items as $item) {
            BillOfMaterialItem::create($item);
        }

        $this->command->info('Default BOM seeded successfully.');
    }
}
