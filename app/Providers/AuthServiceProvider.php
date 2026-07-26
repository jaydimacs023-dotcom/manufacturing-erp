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
use Modules\ProductMaster\Models\Product;
use Modules\ProductMaster\Models\ProductCategory;
use Modules\ProductMaster\Models\ProductSpecification;
use Modules\ProductMaster\Models\UnitOfMeasure;
use Modules\ProductMaster\Policies\ProductCategoryPolicy;
use Modules\ProductMaster\Policies\ProductPolicy;
use Modules\ProductMaster\Policies\ProductSpecificationPolicy;
use Modules\ProductMaster\Policies\UnitOfMeasurePolicy;
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
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
