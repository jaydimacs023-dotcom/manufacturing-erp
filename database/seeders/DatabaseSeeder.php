<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Follows the documented setup order:
     * 1. Company → Branches → Warehouses → Departments
     * 2. Roles & Permissions
     * 3. Admin User
     * 4. Number Series
     */
    public function run(): void
    {
        $this->call([
            DefaultCompanySeeder::class,
            DefaultBranchSeeder::class,
            DefaultWarehouseSeeder::class,
            DefaultDepartmentSeeder::class,
            RoleAndPermissionSeeder::class,
            DefaultUserSeeder::class,
            DefaultProductCategorySeeder::class,
            DefaultUnitOfMeasureSeeder::class,
            DefaultProductSeeder::class,
            DefaultPaymentTermSeeder::class,
            DefaultBusinessPartnerSeeder::class,
            NumberSeriesSeeder::class,
            DefaultBomSeeder::class,
            DefaultQualityControlSeeder::class,
        ]);
    }
}
