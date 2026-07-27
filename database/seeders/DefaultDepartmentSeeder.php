<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Administration\Models\Department;

class DefaultDepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['department_name' => 'Administration', 'department_code' => 'DEPT-ADMIN', 'description' => 'General administration and management', 'is_active' => true],
            ['department_name' => 'Purchasing', 'department_code' => 'DEPT-PUR', 'description' => 'Procurement and supplier management', 'is_active' => true],
            ['department_name' => 'Warehouse', 'department_code' => 'DEPT-WH', 'description' => 'Inventory and warehouse operations', 'is_active' => true],
            ['department_name' => 'Production', 'department_code' => 'DEPT-PROD', 'description' => 'Manufacturing and production', 'is_active' => true],
            ['department_name' => 'Quality Control', 'department_code' => 'DEPT-QC', 'description' => 'Quality assurance and inspection', 'is_active' => true],
            ['department_name' => 'Sales & Export', 'department_code' => 'DEPT-SALES', 'description' => 'Sales, customer management, and export', 'is_active' => true],
            ['department_name' => 'Finance', 'department_code' => 'DEPT-FIN', 'description' => 'Accounting and finance', 'is_active' => true],
        ];

        foreach ($departments as $dept) {
            Department::firstOrCreate(
                ['department_code' => $dept['department_code']],
                $dept
            );
        }
    }
}
