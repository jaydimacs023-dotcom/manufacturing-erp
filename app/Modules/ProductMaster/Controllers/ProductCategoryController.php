<?php

namespace Modules\ProductMaster\Controllers;

use App\Http\Controllers\Controller;
use Modules\ProductMaster\Models\ProductCategory;
use Modules\ProductMaster\Requests\StoreProductCategoryRequest;
use Modules\ProductMaster\Requests\UpdateProductCategoryRequest;
use Modules\ProductMaster\Services\ProductCategoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductCategoryController extends Controller
{
    public function __construct(
        protected ProductCategoryService $categoryService,
    ) {}

    public function index(): View
    {
        $categories = $this->categoryService->getPaginated();
        return view('admin.product-categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.product-categories.create');
    }

    public function store(StoreProductCategoryRequest $request): RedirectResponse
    {
        $this->categoryService->create($request->validated());
        return redirect()->route('admin.product-categories.index')
            ->with('success', 'Product category created successfully.');
    }

    public function edit(ProductCategory $productCategory): View
    {
        return view('admin.product-categories.edit', compact('productCategory'));
    }

    public function update(UpdateProductCategoryRequest $request, ProductCategory $productCategory): RedirectResponse
    {
        $this->categoryService->update($productCategory, $request->validated());
        return redirect()->route('admin.product-categories.index')
            ->with('success', 'Product category updated successfully.');
    }

    public function destroy(ProductCategory $productCategory): RedirectResponse
    {
        $this->categoryService->delete($productCategory);
        return redirect()->route('admin.product-categories.index')
            ->with('success', 'Product category deleted successfully.');
    }
}

