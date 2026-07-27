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
use Modules\ProductMaster\Controllers\ProductCategoryController;
use Modules\ProductMaster\Controllers\ProductController;
use Modules\ProductMaster\Controllers\ProductSpecificationController;
use Modules\ProductMaster\Controllers\UnitOfMeasureController;

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
    });
});

require __DIR__.'/auth.php';
