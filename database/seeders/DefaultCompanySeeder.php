<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Administration\Models\Company;

class DefaultCompanySeeder extends Seeder
{
    public function run(): void
    {
        // Use firstOrCreate to make seeding idempotent
        $company = Company::firstOrCreate(
            ['company_name' => 'Banana Chips Manufacturing Co.'],
            [
                'tin' => '123-456-789-000',
                'registration_number' => 'BNC-2025-001',
                'address' => '123 Industrial Park, Manufacturing Zone',
                'contact_email' => 'info@bananachips.com',
                'contact_phone' => '+63 2 1234 5678',
                'is_active' => true,
            ]
        );

        if (!$company->wasRecentlyCreated) {
            $this->command->info('Company already exists, skipped.');
        }
    }
}
