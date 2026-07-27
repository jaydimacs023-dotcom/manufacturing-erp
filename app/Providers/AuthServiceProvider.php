<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Modules\Administration\Models\Branch;
use Modules\Administration\Models\Department;
use Modules\Administration\Models\Warehouse;
use Modules\Administration\Policies\BranchPolicy;
use Modules\Administration\Policies\DepartmentPolicy;
use Modules\Administration\Policies\RolePolicy;
use Modules\Administration\Policies\UserPolicy;
use Modules\Administration\Policies\WarehousePolicy;
use Modules\BusinessPartner\Models\BusinessPartner;
use Modules\BusinessPartner\Models\ContactPerson;
use Modules\BusinessPartner\Models\PaymentTerm;
use Modules\BusinessPartner\Policies\BusinessPartnerPolicy;
use Modules\BusinessPartner\Policies\ContactPersonPolicy;
use Modules\BusinessPartner\Policies\PaymentTermPolicy;
use Modules\Procurement\Models\GoodsReceipt;
use Modules\Procurement\Models\PurchaseOrder;
use Modules\Procurement\Models\PurchaseRequest;
use Modules\Procurement\Models\SupplierReturn;
use Modules\Procurement\Policies\GoodsReceiptPolicy;
use Modules\Procurement\Policies\PurchaseOrderPolicy;
use Modules\Procurement\Policies\PurchaseRequestPolicy;
use Modules\Procurement\Policies\SupplierReturnPolicy;
use Modules\Inventory\Models\InventoryAdjustment;
use Modules\Inventory\Models\InventoryTransfer;
use Modules\Inventory\Policies\InventoryAdjustmentPolicy;
use Modules\Inventory\Policies\InventoryTransferPolicy;
use Modules\Manufacturing\Models\BillOfMaterial;
use Modules\Manufacturing\Models\ManufacturingOrder;
use Modules\Manufacturing\Policies\BillOfMaterialPolicy;
use Modules\Manufacturing\Policies\ManufacturingOrderPolicy;
use Modules\Manufacturing\Policies\ProductionPolicy;
use Modules\ProductMaster\Models\Product;
use Modules\ProductMaster\Models\ProductCategory;
use Modules\ProductMaster\Models\ProductSpecification;
use Modules\ProductMaster\Models\UnitOfMeasure;
use Modules\ProductMaster\Policies\ProductCategoryPolicy;
use Modules\ProductMaster\Policies\ProductPolicy;
use Modules\ProductMaster\Policies\ProductSpecificationPolicy;
use Modules\ProductMaster\Policies\UnitOfMeasurePolicy;
use Modules\QualityControl\Models\QualityInspection;
use Modules\QualityControl\Models\NonConformance;
use Modules\QualityControl\Models\CorrectiveAction;
use Modules\QualityControl\Policies\QualityInspectionPolicy;
use Modules\QualityControl\Policies\NonConformancePolicy;
use Modules\QualityControl\Policies\CorrectiveActionPolicy;
use Modules\Warehouse\Models\Putaway;
use Modules\Warehouse\Models\WarehouseTransfer;
use Modules\Warehouse\Models\Picking;
use Modules\Warehouse\Models\Dispatch;
use Modules\Warehouse\Policies\PutawayPolicy;
use Modules\Warehouse\Policies\WarehouseTransferPolicy;
use Modules\Warehouse\Policies\PickingPolicy;
use Modules\Warehouse\Policies\DispatchPolicy;
use Modules\Sales\Models\SalesOrder;
use Modules\Sales\Models\ExportOrder;
use Modules\Sales\Policies\SalesOrderPolicy;
use Modules\Sales\Policies\ExportOrderPolicy;
use Modules\Sales\Policies\ShipmentPolicy;
use Modules\Accounting\Models\AccountingEvent;
use Modules\Accounting\Models\JournalMapping;
use Modules\Accounting\Models\AccountMapping;
use Modules\Accounting\Policies\AccountingEventPolicy;
use Modules\Accounting\Policies\AccountMappingPolicy;
use Modules\Reporting\Policies\ReportPolicy;
use Spatie\Permission\Models\Role;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class => UserPolicy::class,
        Role::class => RolePolicy::class,
        Branch::class => BranchPolicy::class,
        Warehouse::class => WarehousePolicy::class,
        Department::class => DepartmentPolicy::class,
        ProductCategory::class => ProductCategoryPolicy::class,
        UnitOfMeasure::class => UnitOfMeasurePolicy::class,
        Product::class => ProductPolicy::class,
        ProductSpecification::class => ProductSpecificationPolicy::class,
        PaymentTerm::class => PaymentTermPolicy::class,
        BusinessPartner::class => BusinessPartnerPolicy::class,
        ContactPerson::class => ContactPersonPolicy::class,
        PurchaseRequest::class => PurchaseRequestPolicy::class,
        PurchaseOrder::class => PurchaseOrderPolicy::class,
        GoodsReceipt::class => GoodsReceiptPolicy::class,
        SupplierReturn::class => SupplierReturnPolicy::class,
InventoryAdjustment::class => InventoryAdjustmentPolicy::class,
        InventoryTransfer::class => InventoryTransferPolicy::class,
        BillOfMaterial::class => BillOfMaterialPolicy::class,
        ManufacturingOrder::class => ManufacturingOrderPolicy::class,
        QualityInspection::class => QualityInspectionPolicy::class,
        NonConformance::class => NonConformancePolicy::class,
        CorrectiveAction::class => CorrectiveActionPolicy::class,
        Putaway::class => PutawayPolicy::class,
        WarehouseTransfer::class => WarehouseTransferPolicy::class,
        Picking::class => PickingPolicy::class,
Dispatch::class => DispatchPolicy::class,

// Sales & Export
        SalesOrder::class => SalesOrderPolicy::class,
        ExportOrder::class => ExportOrderPolicy::class,

        // Reporting
        // ReportPolicy is registered for the module

        // Accounting
        AccountingEvent::class => AccountingEventPolicy::class,
        JournalMapping::class => AccountMappingPolicy::class,
        AccountMapping::class => AccountMappingPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
