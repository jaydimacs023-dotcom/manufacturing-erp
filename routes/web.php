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
    });
});

require __DIR__.'/auth.php';
