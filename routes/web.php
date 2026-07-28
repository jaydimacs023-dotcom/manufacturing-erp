<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Modules\Administration\Controllers\AdminDashboardController;
use Modules\Administration\Controllers\BranchController;
use Modules\Administration\Controllers\CompanyController;
use Modules\Administration\Controllers\DepartmentController;
use Modules\Administration\Controllers\RoleController;
use Modules\Administration\Controllers\UserController;
use Modules\Administration\Controllers\WarehouseController;
use Modules\BusinessPartner\Controllers\BusinessPartnerController;
use Modules\BusinessPartner\Controllers\ContactPersonController;
use Modules\BusinessPartner\Controllers\PaymentTermController;
use Modules\Procurement\Controllers\GoodsReceiptController;
use Modules\Procurement\Controllers\PurchaseOrderController;
use Modules\Procurement\Controllers\PurchaseRequestController;
use Modules\Procurement\Controllers\SupplierReturnController;
use Modules\Inventory\Controllers\InventoryAdjustmentController;
use Modules\Inventory\Controllers\InventoryController;
use Modules\Inventory\Controllers\InventoryTransferController;
use Modules\Manufacturing\Controllers\BillOfMaterialController;
use Modules\Manufacturing\Controllers\ManufacturingOrderController;
use Modules\Manufacturing\Controllers\ProductionController;
use Modules\ProductMaster\Controllers\ProductCategoryController;
use Modules\ProductMaster\Controllers\ProductController;
use Modules\ProductMaster\Controllers\ProductSpecificationController;
use Modules\ProductMaster\Controllers\UnitOfMeasureController;
use Modules\QualityControl\Controllers\QualityInspectionController;
use Modules\QualityControl\Controllers\NonConformanceController;
use Modules\QualityControl\Controllers\CorrectiveActionController;
use Modules\Warehouse\Controllers\PutawayController;
use Modules\Warehouse\Controllers\WarehouseTransferController;
use Modules\Warehouse\Controllers\PickingController;
use Modules\Warehouse\Controllers\DispatchController;

use Modules\Sales\Controllers\SalesOrderController;
use Modules\Sales\Controllers\ExportOrderController;
use Modules\Sales\Controllers\ShipmentController;

use Modules\Accounting\Controllers\AccountingEventController;
use Modules\Accounting\Controllers\PostingQueueController;
use Modules\Accounting\Controllers\AccountMappingController;

use Modules\Reporting\Controllers\ReportController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Administration Module
    Route::prefix('admin')->name('admin.')->group(function () {
        // Admin Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // Company
        Route::get('/company', [CompanyController::class, 'index'])
            ->name('company.index');
        Route::get('/company/edit', [CompanyController::class, 'edit'])
            ->name('company.edit');
        Route::put('/company', [CompanyController::class, 'update'])
            ->name('company.update');

        // Branches
        Route::resource('branches', BranchController::class)
            ->except(['show']);

        // Warehouses
        Route::resource('warehouses', WarehouseController::class)
            ->except(['show']);

        // Departments
        Route::resource('departments', DepartmentController::class)
            ->except(['show']);

        // Users
        Route::resource('users', UserController::class);

        // Roles
        Route::resource('roles', RoleController::class)
            ->except(['show']);

        // Product Master
        Route::resource('product-categories', ProductCategoryController::class)
            ->except(['show']);

        Route::resource('units-of-measure', UnitOfMeasureController::class)
            ->except(['show']);

        Route::resource('products', ProductController::class);

        Route::resource('products.specifications', ProductSpecificationController::class)
            ->except(['show']);

        // Business Partner
        Route::resource('payment-terms', PaymentTermController::class)
            ->except(['show']);

        Route::resource('business-partners', BusinessPartnerController::class);

        Route::resource('business-partners.contact-persons', ContactPersonController::class)
            ->except(['show']);

        // Procurement Module
        Route::resource('purchase-requests', PurchaseRequestController::class);
        Route::post('purchase-requests/{purchase_request}/submit', [PurchaseRequestController::class, 'submit'])
            ->name('purchase-requests.submit');
        Route::post('purchase-requests/{purchase_request}/approve', [PurchaseRequestController::class, 'approve'])
            ->name('purchase-requests.approve');
        Route::post('purchase-requests/{purchase_request}/reject', [PurchaseRequestController::class, 'reject'])
            ->name('purchase-requests.reject');
        Route::post('purchase-requests/{purchase_request}/cancel', [PurchaseRequestController::class, 'cancel'])
            ->name('purchase-requests.cancel');

        Route::resource('purchase-orders', PurchaseOrderController::class);
        Route::post('purchase-orders/{purchase_order}/approve', [PurchaseOrderController::class, 'approve'])
            ->name('purchase-orders.approve');
        Route::post('purchase-orders/{purchase_order}/send', [PurchaseOrderController::class, 'send'])
            ->name('purchase-orders.send');
        Route::post('purchase-orders/{purchase_order}/close', [PurchaseOrderController::class, 'close'])
            ->name('purchase-orders.close');
        Route::post('purchase-orders/{purchase_order}/cancel', [PurchaseOrderController::class, 'cancel'])
            ->name('purchase-orders.cancel');

        Route::resource('goods-receipts', GoodsReceiptController::class);
        Route::post('goods-receipts/{goods_receipt}/complete', [GoodsReceiptController::class, 'complete'])
            ->name('goods-receipts.complete');
        Route::post('goods-receipts/{goods_receipt}/cancel', [GoodsReceiptController::class, 'cancel'])
            ->name('goods-receipts.cancel');

        Route::resource('supplier-returns', SupplierReturnController::class);
        Route::post('supplier-returns/{supplier_return}/complete', [SupplierReturnController::class, 'complete'])
            ->name('supplier-returns.complete');
        Route::post('supplier-returns/{supplier_return}/cancel', [SupplierReturnController::class, 'cancel'])
            ->name('supplier-returns.cancel');

        // Inventory Module
        Route::prefix('inventory')->name('inventory.')->group(function () {
            Route::get('/', [InventoryController::class, 'index'])
                ->name('index');
            Route::get('/stock-card/{product}', [InventoryController::class, 'stockCard'])
                ->name('stock-card');
            Route::get('/movements', [InventoryController::class, 'movements'])
                ->name('movements');

            Route::resource('adjustments', InventoryAdjustmentController::class);
            Route::post('adjustments/{inventory_adjustment}/submit', [InventoryAdjustmentController::class, 'submit'])
                ->name('adjustments.submit');
            Route::post('adjustments/{inventory_adjustment}/approve', [InventoryAdjustmentController::class, 'approve'])
                ->name('adjustments.approve');
            Route::post('adjustments/{inventory_adjustment}/reject', [InventoryAdjustmentController::class, 'reject'])
                ->name('adjustments.reject');
            Route::post('adjustments/{inventory_adjustment}/cancel', [InventoryAdjustmentController::class, 'cancel'])
                ->name('adjustments.cancel');

            Route::resource('transfers', InventoryTransferController::class);
            Route::post('transfers/{inventory_transfer}/complete', [InventoryTransferController::class, 'complete'])
                ->name('transfers.complete');
            Route::post('transfers/{inventory_transfer}/cancel', [InventoryTransferController::class, 'cancel'])
                ->name('transfers.cancel');
        });

        // Manufacturing Module
        Route::prefix('manufacturing')->name('manufacturing.')->group(function () {
            // Bill of Materials
            Route::resource('bom', BillOfMaterialController::class)
                ->except(['show']);
            Route::get('bom/{bill_of_material}', [BillOfMaterialController::class, 'show'])
                ->name('bom.show');
            Route::post('bom/{bill_of_material}/approve', [BillOfMaterialController::class, 'approve'])
                ->name('bom.approve');

            // Manufacturing Orders
            Route::resource('orders', ManufacturingOrderController::class);
            Route::post('orders/{manufacturing_order}/release', [ManufacturingOrderController::class, 'release'])
                ->name('orders.release');
            Route::post('orders/{manufacturing_order}/start', [ManufacturingOrderController::class, 'start'])
                ->name('orders.start');
            Route::post('orders/{manufacturing_order}/complete', [ManufacturingOrderController::class, 'complete'])
                ->name('orders.complete');
            Route::post('orders/{manufacturing_order}/close', [ManufacturingOrderController::class, 'close'])
                ->name('orders.close');
            Route::post('orders/{manufacturing_order}/cancel', [ManufacturingOrderController::class, 'cancel'])
                ->name('orders.cancel');
            Route::get('orders/bom-for-product/{productId}', [ManufacturingOrderController::class, 'getBomForProduct'])
                ->name('orders.bom-for-product');

            // Production
            Route::prefix('production')->name('production.')->group(function () {
                Route::get('/', [ProductionController::class, 'index'])
                    ->name('index');
                Route::get('/{moId}', [ProductionController::class, 'show'])
                    ->name('show');

                // Material Issues
                Route::get('/issue/create', [ProductionController::class, 'createIssue'])
                    ->name('issue');
                Route::post('/issue', [ProductionController::class, 'storeIssue'])
                    ->name('store-issue');

                // Production Outputs
                Route::get('/output/create', [ProductionController::class, 'createOutput'])
                    ->name('output');
                Route::post('/output', [ProductionController::class, 'storeOutput'])
                    ->name('store-output');
                Route::post('/output/{production_output}/approve', [ProductionController::class, 'approveOutput'])
                    ->name('output.approve');
                Route::post('/output/{production_output}/reject', [ProductionController::class, 'rejectOutput'])
                    ->name('output.reject');

                // Waste Records
                Route::get('/waste/create', [ProductionController::class, 'createWaste'])
                    ->name('waste');
                Route::post('/waste', [ProductionController::class, 'storeWaste'])
                    ->name('store-waste');
            });
        });

        // Warehouse Module
        Route::prefix('warehouse')->name('warehouse.')->group(function () {
            // Storage Location AJAX
            Route::get('/locations/{warehouseId}', [PutawayController::class, 'getLocationsByWarehouse'])
                ->name('locations.by-warehouse');

            // Put-away
            Route::resource('putaway', PutawayController::class)
                ->only(['index', 'create', 'store', 'show']);
            Route::post('putaway/{putaway}/complete', [PutawayController::class, 'complete'])
                ->name('putaway.complete');
            Route::post('putaway/{putaway}/cancel', [PutawayController::class, 'cancel'])
                ->name('putaway.cancel');

            // Warehouse Transfers
            Route::resource('transfers', WarehouseTransferController::class)
                ->only(['index', 'create', 'store', 'show']);
            Route::post('transfers/{warehouse_transfer}/approve', [WarehouseTransferController::class, 'approve'])
                ->name('transfers.approve');
            Route::post('transfers/{warehouse_transfer}/complete', [WarehouseTransferController::class, 'complete'])
                ->name('transfers.complete');
            Route::post('transfers/{warehouse_transfer}/cancel', [WarehouseTransferController::class, 'cancel'])
                ->name('transfers.cancel');

            // Picking
            Route::resource('picking', PickingController::class)
                ->only(['index', 'create', 'store', 'show']);
            Route::post('picking/{picking}/complete', [PickingController::class, 'complete'])
                ->name('picking.complete');
            Route::post('picking/{picking}/cancel', [PickingController::class, 'cancel'])
                ->name('picking.cancel');

            // Dispatch
            Route::resource('dispatch', DispatchController::class)
                ->only(['index', 'create', 'store', 'show']);
            Route::post('dispatch/{dispatch}/pack', [DispatchController::class, 'pack'])
                ->name('dispatch.pack');
            Route::post('dispatch/{dispatch}/load', [DispatchController::class, 'load'])
                ->name('dispatch.load');
            Route::post('dispatch/{dispatch}/confirm', [DispatchController::class, 'confirm'])
                ->name('dispatch.confirm');
            Route::post('dispatch/{dispatch}/cancel', [DispatchController::class, 'cancel'])
                ->name('dispatch.cancel');
        });

// Sales & Export Module
        Route::prefix('sales')->name('sales.')->group(function () {
            // Sales Orders
            Route::resource('sales-orders', SalesOrderController::class);
            Route::post('sales-orders/{sales_order}/submit', [SalesOrderController::class, 'submit'])
                ->name('sales-orders.submit');
            Route::post('sales-orders/{sales_order}/approve', [SalesOrderController::class, 'approve'])
                ->name('sales-orders.approve');
            Route::post('sales-orders/{sales_order}/cancel', [SalesOrderController::class, 'cancel'])
                ->name('sales-orders.cancel');

            // Export Orders
            Route::resource('export-orders', ExportOrderController::class);
            Route::post('export-orders/{export_order}/approve', [ExportOrderController::class, 'approve'])
                ->name('export-orders.approve');
            Route::post('export-orders/{export_order}/load', [ExportOrderController::class, 'load'])
                ->name('export-orders.load');
            Route::post('export-orders/{export_order}/dispatch', [ExportOrderController::class, 'dispatch'])
                ->name('export-orders.dispatch');
            Route::post('export-orders/{export_order}/in-transit', [ExportOrderController::class, 'markInTransit'])
                ->name('export-orders.in-transit');
            Route::post('export-orders/{export_order}/deliver', [ExportOrderController::class, 'markDelivered'])
                ->name('export-orders.deliver');
            Route::post('export-orders/{export_order}/cancel', [ExportOrderController::class, 'cancel'])
                ->name('export-orders.cancel');

            // Shipments (Packing Lists & Commercial Invoices)
            Route::prefix('shipments')->name('shipments.')->group(function () {
                Route::get('/', [ShipmentController::class, 'index'])
                    ->name('index');

                // Packing Lists
                Route::get('/packing-lists/create', [ShipmentController::class, 'createPackingList'])
                    ->name('create-packing-list');
                Route::post('/packing-lists', [ShipmentController::class, 'storePackingList'])
                    ->name('store-packing-list');
                Route::get('/packing-lists/{packing_list}', [ShipmentController::class, 'showPackingList'])
                    ->name('show-packing-list');
                Route::delete('/packing-lists/{packing_list}', [ShipmentController::class, 'destroyPackingList'])
                    ->name('destroy-packing-list');

                // Commercial Invoices
                Route::get('/invoices/create', [ShipmentController::class, 'createInvoice'])
                    ->name('create-invoice');
                Route::post('/invoices', [ShipmentController::class, 'storeInvoice'])
                    ->name('store-invoice');
                Route::get('/invoices/{commercial_invoice}', [ShipmentController::class, 'showInvoice'])
                    ->name('show-invoice');
                Route::delete('/invoices/{commercial_invoice}', [ShipmentController::class, 'destroyInvoice'])
                    ->name('destroy-invoice');
            });
        });

// Accounting Module
        Route::prefix('accounting')->name('accounting.')->group(function () {
            // Accounting Events
            Route::resource('events', AccountingEventController::class)
                ->only(['index', 'show']);
            Route::post('events/{event}/post', [AccountingEventController::class, 'post'])
                ->name('events.post');
            Route::post('events/{event}/repost', [AccountingEventController::class, 'repost'])
                ->name('events.repost');
            Route::post('events/{event}/cancel', [AccountingEventController::class, 'cancel'])
                ->name('events.cancel');

            // Posting Queue
            Route::resource('posting-queue', PostingQueueController::class)
                ->only(['index', 'show']);
            Route::post('posting-queue/{queue}/process', [PostingQueueController::class, 'process'])
                ->name('posting-queue.process');
            Route::post('posting-queue/{queue}/retry', [PostingQueueController::class, 'retry'])
                ->name('posting-queue.retry');
            Route::post('posting-queue/process-all', [PostingQueueController::class, 'processAll'])
                ->name('posting-queue.process-all');

            // Mappings
            Route::prefix('mappings')->name('mappings.')->group(function () {
                Route::get('/', [AccountMappingController::class, 'index'])
                    ->name('index');

                Route::get('/accounts/create', [AccountMappingController::class, 'createAccountMapping'])
                    ->name('create-account');
                Route::post('/accounts', [AccountMappingController::class, 'storeAccountMapping'])
                    ->name('store-account');
                Route::get('/accounts/{account_mapping}/edit', [AccountMappingController::class, 'editAccountMapping'])
                    ->name('edit-account');
                Route::put('/accounts/{account_mapping}', [AccountMappingController::class, 'updateAccountMapping'])
                    ->name('update-account');

                Route::get('/journals/create', [AccountMappingController::class, 'createJournalMapping'])
                    ->name('create-journal');
                Route::post('/journals', [AccountMappingController::class, 'storeJournalMapping'])
                    ->name('store-journal');
                Route::get('/journals/{journal_mapping}/edit', [AccountMappingController::class, 'editJournalMapping'])
                    ->name('edit-journal');
                Route::put('/journals/{journal_mapping}', [AccountMappingController::class, 'updateJournalMapping'])
                    ->name('update-journal');
            });
        });

        // Reports Module
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/', [ReportController::class, 'index'])
                ->name('index');

            // Procurement Reports
            Route::get('/procurement', [ReportController::class, 'procurementReport'])
                ->name('procurement');
            Route::get('/procurement/export', [ReportController::class, 'exportProcurementReport'])
                ->name('procurement.export');

            // Inventory Reports
            Route::get('/inventory', [ReportController::class, 'inventoryReport'])
                ->name('inventory');
            Route::get('/inventory/export', [ReportController::class, 'exportInventoryReport'])
                ->name('inventory.export');

            // Manufacturing Reports
            Route::get('/manufacturing', [ReportController::class, 'manufacturingReport'])
                ->name('manufacturing');
            Route::get('/manufacturing/export', [ReportController::class, 'exportManufacturingReport'])
                ->name('manufacturing.export');

            // Quality Control Reports
            Route::get('/quality', [ReportController::class, 'qualityReport'])
                ->name('quality');
            Route::get('/quality/export', [ReportController::class, 'exportQualityReport'])
                ->name('quality.export');

            // Warehouse Reports
            Route::get('/warehouse', [ReportController::class, 'warehouseReport'])
                ->name('warehouse');
            Route::get('/warehouse/export', [ReportController::class, 'exportWarehouseReport'])
                ->name('warehouse.export');

            // Sales Reports
            Route::get('/sales', [ReportController::class, 'salesReport'])
                ->name('sales');
            Route::get('/sales/export', [ReportController::class, 'exportSalesReport'])
                ->name('sales.export');

            // Accounting Reports
            Route::get('/accounting', [ReportController::class, 'accountingReport'])
                ->name('accounting');
            Route::get('/accounting/export', [ReportController::class, 'exportAccountingReport'])
                ->name('accounting.export');

            // Executive Dashboard
            Route::get('/executive', [ReportController::class, 'executive'])
                ->name('executive');
        });

        // Quality Control Module
        Route::prefix('quality-control')->name('quality-control.')->group(function () {
            // Inspections
            Route::resource('inspections', QualityInspectionController::class);
            Route::put('inspections/{quality_inspection}/record-results', [QualityInspectionController::class, 'recordResults'])
                ->name('inspections.record-results');
            Route::post('inspections/{quality_inspection}/approve', [QualityInspectionController::class, 'approve'])
                ->name('inspections.approve');
            Route::post('inspections/{quality_inspection}/reject', [QualityInspectionController::class, 'reject'])
                ->name('inspections.reject');
            Route::post('inspections/{quality_inspection}/conditional', [QualityInspectionController::class, 'conditionalAccept'])
                ->name('inspections.conditional');
            Route::post('inspections/{quality_inspection}/cancel', [QualityInspectionController::class, 'cancel'])
                ->name('inspections.cancel');

            // Non-Conformances
            Route::resource('non-conformances', NonConformanceController::class);
            Route::put('non-conformances/{non_conformance}/resolve', [NonConformanceController::class, 'resolve'])
                ->name('non-conformances.resolve');
            Route::post('non-conformances/{non_conformance}/close', [NonConformanceController::class, 'close'])
                ->name('non-conformances.close');

            // Corrective Actions
            Route::resource('corrective-actions', CorrectiveActionController::class);
            Route::post('corrective-actions/{corrective_action}/start', [CorrectiveActionController::class, 'start'])
                ->name('corrective-actions.start');
            Route::put('corrective-actions/{corrective_action}/complete', [CorrectiveActionController::class, 'complete'])
                ->name('corrective-actions.complete');
            Route::post('corrective-actions/{corrective_action}/approve', [CorrectiveActionController::class, 'approve'])
                ->name('corrective-actions.approve');
        });
    });
});

require __DIR__.'/auth.php';
