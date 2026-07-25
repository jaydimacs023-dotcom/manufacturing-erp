<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Administration\Models\Branch;

class DefaultBranchSeeder extends Seeder
{
    public function run(): void
    {
        Branch::create([
            'branch_name' => 'Main Plant',
            'branch_code' => 'BR-MAIN',
            'address' => '123 Industrial Park, Manufacturing Zone',
            'contact_number' => '+63 2 1234 5678',
            'is_active' => true,
            'company_id' => 1,
        ]);
    }
}
