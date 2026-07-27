<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions grouped by module
        $permissions = [
            // Business Partner
            'business-partner-view', 'business-partner-create', 'business-partner-update', 'business-partner-delete',

            // Product Master
            'product-view', 'product-create', 'product-update', 'product-delete',
            'product-category-view', 'product-category-create', 'product-category-update', 'product-category-delete',
            'uom-view', 'uom-create', 'uom-update', 'uom-delete',

            // Administration
            'view-administration',
            'branch-view', 'branch-create', 'branch-update', 'branch-delete',
            'warehouse-view', 'warehouse-create', 'warehouse-update', 'warehouse-delete',
            'department-view', 'department-create', 'department-update', 'department-delete',
            'user-view', 'user-create', 'user-update', 'user-delete',
            'role-view', 'role-create', 'role-update', 'role-delete',
            'settings-view', 'settings-update',
            'audit-view',
            'number-series-view', 'number-series-create', 'number-series-update', 'number-series-delete',

            // Procurement
            'procurement-view',
            'purchase-request-view', 'purchase-request-create', 'purchase-request-update', 'purchase-request-approve', 'purchase-request-reject', 'purchase-request-submit', 'purchase-request-cancel', 'purchase-request-delete',
            'purchase-order-view', 'purchase-order-create', 'purchase-order-update', 'purchase-order-approve', 'purchase-order-send', 'purchase-order-close', 'purchase-order-cancel', 'purchase-order-delete',
            'goods-receipt-view', 'goods-receipt-create', 'goods-receipt-update', 'goods-receipt-complete', 'goods-receipt-cancel', 'goods-receipt-delete',
            'supplier-return-view', 'supplier-return-create', 'supplier-return-update', 'supplier-return-complete', 'supplier-return-cancel', 'supplier-return-delete',

            // Inventory
            'inventory-view', 'inventory-adjust', 'inventory-transfer',
            'batch-view', 'batch-create',

            // Manufacturing
            'bom-view', 'bom-create', 'bom-update', 'bom-delete',
            'manufacturing-order-view', 'manufacturing-order-create', 'manufacturing-order-update',
            'manufacturing-order-start', 'manufacturing-order-complete', 'manufacturing-order-cancel',

            // Quality Control
            'inspection-view', 'inspection-create', 'inspection-approve',
            'non-conformance-view', 'non-conformance-create', 'corrective-action-view', 'corrective-action-create',

            // Warehouse
            'putaway-view', 'putaway-create',
            'picking-view', 'picking-create',
            'dispatch-view', 'dispatch-create',
            'packing-view', 'packing-create',

            // Sales & Export
            'sales-order-view', 'sales-order-create', 'sales-order-update', 'sales-order-approve',
            'export-order-view', 'export-order-create', 'export-order-update', 'export-order-approve',
            'shipment-view', 'shipment-create',

            // Accounting
            'accounting-event-view', 'accounting-event-post',
            'journal-view',

            // Reporting
            'report-view', 'report-export',
            'dashboard-view',
        ];

foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

// Create roles and assign permissions
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $superAdmin->givePermissionTo(Permission::all());

        $admin = Role::firstOrCreate(['name' => 'Administrator', 'guard_name' => 'web']);
        $admin->givePermissionTo([
            'business-partner-view', 'business-partner-create', 'business-partner-update', 'business-partner-delete',
            'product-view', 'product-create', 'product-update', 'product-delete',
            'product-category-view', 'product-category-create', 'product-category-update', 'product-category-delete',
            'uom-view', 'uom-create', 'uom-update', 'uom-delete',
            'view-administration',
            'branch-view', 'branch-create', 'branch-update', 'branch-delete',
            'warehouse-view', 'warehouse-create', 'warehouse-update', 'warehouse-delete',
            'department-view', 'department-create', 'department-update', 'department-delete',
            'user-view', 'user-create', 'user-update', 'user-delete',
            'role-view', 'role-create', 'role-update', 'role-delete',
            'settings-view', 'settings-update',
            'audit-view',
            'number-series-view', 'number-series-create', 'number-series-update', 'number-series-delete',
            'procurement-view',
            'purchase-request-view', 'purchase-request-create', 'purchase-request-update', 'purchase-request-approve', 'purchase-request-reject', 'purchase-request-submit', 'purchase-request-cancel', 'purchase-request-delete',
            'purchase-order-view', 'purchase-order-create', 'purchase-order-update', 'purchase-order-approve', 'purchase-order-send', 'purchase-order-close', 'purchase-order-cancel', 'purchase-order-delete',
            'goods-receipt-view', 'goods-receipt-create', 'goods-receipt-update', 'goods-receipt-complete', 'goods-receipt-cancel', 'goods-receipt-delete',
            'supplier-return-view', 'supplier-return-create', 'supplier-return-update', 'supplier-return-complete', 'supplier-return-cancel', 'supplier-return-delete',
            'dashboard-view',
        ]);

$purchasingOfficer = Role::firstOrCreate(['name' => 'Purchasing Officer', 'guard_name' => 'web']);
$purchasingOfficer->givePermissionTo([
            'business-partner-view',
            'product-view',
            'product-category-view',
            'uom-view',
            'procurement-view',
            'purchase-request-view', 'purchase-request-create', 'purchase-request-update', 'purchase-request-submit', 'purchase-request-cancel',
            'purchase-order-view', 'purchase-order-create', 'purchase-order-update', 'purchase-order-send', 'purchase-order-close',
            'goods-receipt-view', 'goods-receipt-create', 'goods-receipt-update', 'goods-receipt-complete', 'goods-receipt-cancel',
            'supplier-return-view', 'supplier-return-create', 'supplier-return-update', 'supplier-return-complete', 'supplier-return-cancel',
            'dashboard-view',
        ]);

$warehouseStaff = Role::firstOrCreate(['name' => 'Warehouse Staff', 'guard_name' => 'web']);
        $warehouseStaff->givePermissionTo([
            'product-view',
            'product-category-view',
            'uom-view',
            'inventory-view',
            'batch-view', 'batch-create',
            'putaway-view', 'putaway-create',
            'picking-view', 'picking-create',
            'packing-view', 'packing-create',
            'dispatch-view', 'dispatch-create',
            'dashboard-view',
        ]);

$productionSupervisor = Role::firstOrCreate(['name' => 'Production Supervisor', 'guard_name' => 'web']);
        $productionSupervisor->givePermissionTo([
            'product-view',
            'product-category-view',
            'uom-view',
            'bom-view', 'bom-create', 'bom-update',
            'manufacturing-order-view', 'manufacturing-order-create', 'manufacturing-order-update',
            'manufacturing-order-start', 'manufacturing-order-complete', 'manufacturing-order-cancel',
            'inventory-view',
            'dashboard-view',
        ]);

$qualityInspector = Role::firstOrCreate(['name' => 'Quality Inspector', 'guard_name' => 'web']);
        $qualityInspector->givePermissionTo([
            'inspection-view', 'inspection-create', 'inspection-approve',
            'non-conformance-view', 'non-conformance-create',
            'corrective-action-view', 'corrective-action-create',
            'dashboard-view',
        ]);

$salesOfficer = Role::firstOrCreate(['name' => 'Sales Officer', 'guard_name' => 'web']);
        $salesOfficer->givePermissionTo([
            'business-partner-view',
            'product-view',
            'product-category-view',
            'uom-view',
            'sales-order-view', 'sales-order-create', 'sales-order-update',
            'export-order-view', 'export-order-create',
            'shipment-view', 'shipment-create',
            'dashboard-view',
        ]);

$exportOfficer = Role::firstOrCreate(['name' => 'Export Officer', 'guard_name' => 'web']);
        $exportOfficer->givePermissionTo([
            'business-partner-view',
            'product-view',
            'product-category-view',
            'uom-view',
            'export-order-view', 'export-order-create', 'export-order-update', 'export-order-approve',
            'sales-order-view',
            'shipment-view', 'shipment-create',
            'dashboard-view',
        ]);

$accountingOfficer = Role::firstOrCreate(['name' => 'Accounting Officer', 'guard_name' => 'web']);
        $accountingOfficer->givePermissionTo([
            'product-view',
            'product-category-view',
            'uom-view',
            'accounting-event-view', 'accounting-event-post',
            'journal-view',
            'dashboard-view',
        ]);
    }
}
