<?php

namespace Modules\ProductMaster\Controllers;

use App\Http\Controllers\Controller;
use Modules\ProductMaster\Models\Product;
use Modules\ProductMaster\Requests\StoreProductRequest;
use Modules\ProductMaster\Requests\UpdateProductRequest;
use Modules\ProductMaster\Services\ProductCategoryService;
use Modules\ProductMaster\Services\ProductService;
use Modules\ProductMaster\Services\ProductSpecificationService;
use Modules\ProductMaster\Services\UnitOfMeasureService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService,
        protected ProductCategoryService $categoryService,
        protected UnitOfMeasureService $uomService,
        protected ProductSpecificationService $specificationService,
    ) {}

    public function index(): View
    {
        $products = $this->productService->getPaginated();
        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = $this->categoryService->getActiveCategories();
        $uoms = $this->uomService->getActiveUoms();
        $productTypes = [
            'raw_material' => 'Raw Material',
            'packaging' => 'Packaging',
            'finished_good' => 'Finished Good',
            'consumable' => 'Consumable',
        ];
        return view('admin.products.create', compact('categories', 'uoms', 'productTypes'));
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $this->productService->create($request->validated());
        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product): View
    {
        $product->load(['category', 'defaultUom', 'specifications']);
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product): View
    {
        $categories = $this->categoryService->getActiveCategories();
        $uoms = $this->uomService->getActiveUoms();
        $productTypes = [
            'raw_material' => 'Raw Material',
            'packaging' => 'Packaging',
            'finished_good' => 'Finished Good',
            'consumable' => 'Consumable',
        ];
        return view('admin.products.edit', compact('product', 'categories', 'uoms', 'productTypes'));
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $this->productService->update($product, $request->validated());
        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->productService->delete($product);
        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}

