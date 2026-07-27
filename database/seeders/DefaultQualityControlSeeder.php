<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DefaultQualityControlSeeder extends Seeder
{
    public function run(): void
    {
        // Inspection Types
        $inspectionTypes = [];
        foreach ([
            ['code' => 'IQC', 'name' => 'Incoming Quality Inspection', 'description' => 'Inspection of raw materials received from suppliers', 'category' => 'incoming'],
            ['code' => 'IPQC', 'name' => 'In-Process Quality Inspection', 'description' => 'Inspection during manufacturing process', 'category' => 'in_process'],
            ['code' => 'FQC', 'name' => 'Finished Goods Inspection', 'description' => 'Final inspection of finished products before warehousing', 'category' => 'final'],
        ] as $item) {
            $inspectionTypes[] = array_merge($item, [
                'uuid' => (string) Str::uuid(),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        foreach ($inspectionTypes as $item) {
            DB::table('inspection_types')->updateOrInsert(
                ['code' => $item['code']],
                $item
            );
        }

        // Defect Types
        $defectTypes = [];
        foreach ([
            ['code' => 'DIM', 'name' => 'Dimension Defect', 'severity' => 'critical', 'description' => 'Product dimensions out of specification'],
            ['code' => 'APP', 'name' => 'Appearance Defect', 'severity' => 'major', 'description' => 'Visual appearance does not meet standards'],
            ['code' => 'WGT', 'name' => 'Weight Defect', 'severity' => 'critical', 'description' => 'Product weight out of acceptable range'],
            ['code' => 'SEAL', 'name' => 'Packaging Seal Defect', 'severity' => 'major', 'description' => 'Packaging seal is broken or improper'],
            ['code' => 'LBL', 'name' => 'Label Defect', 'severity' => 'minor', 'description' => 'Label information is missing or incorrect'],
            ['code' => 'CONT', 'name' => 'Contamination', 'severity' => 'critical', 'description' => 'Foreign material present in product'],
            ['code' => 'CLR', 'name' => 'Color Defect', 'severity' => 'major', 'description' => 'Product color out of specification'],
            ['code' => 'TST', 'name' => 'Taste Defect', 'severity' => 'critical', 'description' => 'Product taste does not meet standards'],
            ['code' => 'TEX', 'name' => 'Texture Defect', 'severity' => 'major', 'description' => 'Product texture out of specification'],
            ['code' => 'EXP', 'name' => 'Expiry Date Defect', 'severity' => 'critical', 'description' => 'Expiry date missing or incorrect'],
        ] as $item) {
            $defectTypes[] = array_merge($item, [
                'uuid' => (string) Str::uuid(),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        foreach ($defectTypes as $item) {
            DB::table('defect_types')->updateOrInsert(
                ['code' => $item['code']],
                $item
            );
        }

        // Quality Checklists
        $checklists = [];
        foreach ([
            ['inspection_type_id' => 1, 'code' => 'IQC-BASIC', 'name' => 'Incoming Raw Materials Checklist', 'description' => 'Standard checklist for incoming raw material inspection'],
            ['inspection_type_id' => 2, 'code' => 'IPQC-PROCESS', 'name' => 'In-Process Production Checklist', 'description' => 'Standard checklist for in-process quality checks'],
            ['inspection_type_id' => 3, 'code' => 'FQC-FINAL', 'name' => 'Finished Goods Checklist', 'description' => 'Standard checklist for final product inspection'],
        ] as $item) {
            $checklists[] = array_merge($item, [
                'uuid' => (string) Str::uuid(),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        foreach ($checklists as $item) {
            DB::table('quality_checklists')->updateOrInsert(
                ['code' => $item['code']],
                $item
            );
        }

        // Checklist Items
        DB::table('quality_checklist_items')->insert([
            // Incoming Raw Materials Checklist items
            ['quality_checklist_id' => 1, 'item_name' => 'Visual Inspection', 'specification' => 'Check for visible defects, discoloration, or foreign matter', 'expected_value' => 'No visible defects', 'is_required' => true, 'sort_order' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['quality_checklist_id' => 1, 'item_name' => 'Packaging Integrity', 'specification' => 'Check packaging for damage, tears, or leaks', 'expected_value' => 'Packaging intact and sealed', 'is_required' => true, 'sort_order' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['quality_checklist_id' => 1, 'item_name' => 'Quantity Verification', 'specification' => 'Verify received quantity matches delivery note', 'expected_value' => 'Quantity matches documentation', 'is_required' => true, 'sort_order' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['quality_checklist_id' => 1, 'item_name' => 'Batch Number', 'specification' => 'Verify batch/lot number is present and legible', 'expected_value' => 'Batch number present and legible', 'is_required' => true, 'sort_order' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['quality_checklist_id' => 1, 'item_name' => 'Expiry Date', 'specification' => 'Verify expiry date is within acceptable range', 'expected_value' => 'Expiry date is acceptable', 'is_required' => true, 'sort_order' => 5, 'created_at' => now(), 'updated_at' => now()],

            // In-Process Production Checklist items
            ['quality_checklist_id' => 2, 'item_name' => 'Slice Thickness', 'specification' => 'Measure slice thickness using calipers', 'expected_value' => 'Within specified range (±0.5mm)', 'is_required' => true, 'sort_order' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['quality_checklist_id' => 2, 'item_name' => 'Frying Temperature', 'specification' => 'Verify oil temperature is at specified value', 'expected_value' => '170-180°C', 'is_required' => true, 'sort_order' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['quality_checklist_id' => 2, 'item_name' => 'Frying Time', 'specification' => 'Verify frying duration per batch', 'expected_value' => '3-4 minutes per batch', 'is_required' => true, 'sort_order' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['quality_checklist_id' => 2, 'item_name' => 'Oil Quality', 'specification' => 'Check oil clarity and odor', 'expected_value' => 'Clean, clear oil with normal odor', 'is_required' => true, 'sort_order' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['quality_checklist_id' => 2, 'item_name' => 'Product Color', 'specification' => 'Check product color against standard', 'expected_value' => 'Golden yellow, consistent color', 'is_required' => true, 'sort_order' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['quality_checklist_id' => 2, 'item_name' => 'Seasoning Consistency', 'specification' => 'Verify seasoning distribution and coverage', 'expected_value' => 'Even seasoning coverage', 'is_required' => true, 'sort_order' => 6, 'created_at' => now(), 'updated_at' => now()],

            // Finished Goods Checklist items
            ['quality_checklist_id' => 3, 'item_name' => 'Product Weight', 'specification' => 'Weigh finished product package', 'expected_value' => 'Within specified weight range', 'is_required' => true, 'sort_order' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['quality_checklist_id' => 3, 'item_name' => 'Packaging Seal', 'specification' => 'Verify packaging seal is intact and secure', 'expected_value' => 'Seal intact and secure', 'is_required' => true, 'sort_order' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['quality_checklist_id' => 3, 'item_name' => 'Label Accuracy', 'specification' => 'Verify label information is complete and correct', 'expected_value' => 'All required information present and accurate', 'is_required' => true, 'sort_order' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['quality_checklist_id' => 3, 'item_name' => 'Product Appearance', 'specification' => 'Check product appearance and presentation', 'expected_value' => 'Consistent appearance, no visible defects', 'is_required' => true, 'sort_order' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['quality_checklist_id' => 3, 'item_name' => 'Taste Test', 'specification' => 'Perform taste test on sample', 'expected_value' => 'Meets taste profile standards', 'is_required' => true, 'sort_order' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['quality_checklist_id' => 3, 'item_name' => 'Batch Number', 'specification' => 'Verify batch number is printed on package', 'expected_value' => 'Batch number legible on package', 'is_required' => true, 'sort_order' => 6, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

