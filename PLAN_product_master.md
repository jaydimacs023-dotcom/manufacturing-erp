# Product Master Domain Implementation Plan

## Domain Document: 02_Product_Master_Domain.md
## Dependencies: Administration (Phase 1 complete)

### Information Gathered:
- Admin module uses `app/Modules/Administration/` structure with Models, Repositories, Services, Requests, Policies, Controllers
- Models use UUID, SoftDeletes, boot() for auto UUID/audit fields
- Repositories extend `App\Repositories\BaseRepository`
- Services use constructor DI with NumberSeriesService
- Controllers are thin, delegate to Services
- Blade views use `layouts.app` with `@section('page-header', ...)` pattern
- Views use components: `x-card`, `x-table`, `x-button`, `x-input`, `x-select`, `x-textarea`, `x-checkbox`, `x-badge`
- Policies check permissions like `user->can('branch-view')`
- Routes use `admin.*` prefix
- AuthServiceProvider registers policies
- Sidebar has Administration section with accordion

### Plan:

**Step 1: Create Migrations (4 tables)**
1. `product_categories` — id, uuid, category_code, category_name, description, is_active, created_by, updated_by, deleted_by, soft_deletes
2. `units_of_measure` — id, uuid, uom_code, uom_name, uom_type (reference/transactional), is_active, created_by, updated_by, deleted_by, soft_deletes
3. `products` — id, uuid, product_code, product_name, product_type (raw_material/packaging/finished_good/consumable), category_id (FK), default_uom_id (FK), description, shelf_life_days, is_active, image_path, created_by, updated_by, deleted_by, soft_deletes
4. `product_specifications` — id, uuid, product_id (FK), spec_name, spec_value, created_by, updated_by

**Step 2: Create Models (4)**
- ProductCategory — belongsTo company? no, just standalone
- UnitOfMeasure — standalone
- Product — belongsTo category, belongsTo defaultUom, hasMany specifications
- ProductSpecification — belongsTo product

**Step 3: Create Repositories (4)**
- ProductCategoryRepository
- UnitOfMeasureRepository
- ProductRepository
- ProductSpecificationRepository

**Step 4: Create Services (4)**
- ProductCategoryService
- UnitOfMeasureService
- ProductService
- ProductSpecificationService

**Step 5: Create Form Requests (8 - Store/Update for each)**
- StoreProductCategoryRequest, UpdateProductCategoryRequest
- StoreUnitOfMeasureRequest, UpdateUnitOfMeasureRequest
- StoreProductRequest, UpdateProductRequest
- StoreProductSpecificationRequest, UpdateProductSpecificationRequest

**Step 6: Create Policies (4)**
- ProductCategoryPolicy
- UnitOfMeasurePolicy
- ProductPolicy
- ProductSpecificationPolicy

**Step 7: Create Controllers (4)**
- ProductCategoryController (CRUD, except show)
- UnitOfMeasureController (CRUD, except show)
- ProductController (CRUD)
- ProductSpecificationController (CRUD, except show)

**Step 8: Add Routes**
- `admin/product-categories` resource
- `admin/units-of-measure` resource
- `admin/products` resource (with show)
- `admin/products/{product}/specifications` nested resource

**Step 9: Create Blade Views**
- `resources/views/admin/product-categories/index.blade.php`, `create.blade.php`, `edit.blade.php`, `_actions.blade.php`
- `resources/views/admin/units-of-measure/index.blade.php`, `create.blade.php`, `edit.blade.php`, `_actions.blade.php`
- `resources/views/admin/products/index.blade.php`, `create.blade.php`, `edit.blade.php`, `show.blade.php`, `_actions.blade.php`
- `resources/views/admin/product-specifications/index.blade.php`, `create.blade.php`, `edit.blade.php`, `_actions.blade.php`

**Step 10: Update Existing Files**
- `app/Providers/AuthServiceProvider.php` — register new policies
- `resources/views/components/sidebar.blade.php` — add Product Master section
- `database/seeders/RoleAndPermissionSeeder.php` — add product permissions
- `routes/web.php` — add new routes

**Step 11: Create Seeders**
- `DefaultProductCategorySeeder` — Raw Materials, Finished Goods, Packaging, Consumables
- `DefaultUnitOfMeasureSeeder` — kg, g, L, ml, pc, pack, box, carton
- `DefaultProductSeeder` — sample products (Saba Banana, Cooking Oil, etc.)

**Step 12: Run migrations and seeders**

