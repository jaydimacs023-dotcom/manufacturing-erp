<?php

namespace Modules\ProductMaster\Controllers;

use App\Http\Controllers\Controller;
use Modules\ProductMaster\Models\Product;
use Modules\ProductMaster\Models\ProductSpecification;
use Modules\ProductMaster\Requests\StoreProductSpecificationRequest;
use Modules\ProductMaster\Requests\UpdateProductSpecificationRequest;
use Modules\ProductMaster\Services\ProductSpecificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductSpecificationController extends Controller
{
    public function __construct(
        protected ProductSpecificationService $specificationService,
    ) {}

    public function index(Product $product): View
    {
        $specifications = $this->specificationService->getByProduct($product->id);
        return view('admin.product-specifications.index', compact('product', 'specifications'));
    }

    public function create(Product $product): View
    {
        return view('admin.product-specifications.create', compact('product'));
    }

    public function store(StoreProductSpecificationRequest $request, Product $product): RedirectResponse
    {
        $this->specificationService->create($product, $request->validated());
        return redirect()->route('admin.products.specifications.index', $product)
            ->with('success', 'Specification added successfully.');
    }

    public function edit(Product $product, ProductSpecification $specification): View
    {
        return view('admin.product-specifications.edit', compact('product', 'specification'));
    }

    public function update(UpdateProductSpecificationRequest $request, Product $product, ProductSpecification $specification): RedirectResponse
    {
        $this->specificationService->update($specification, $request->validated());
        return redirect()->route('admin.products.specifications.index', $product)
            ->with('success', 'Specification updated successfully.');
    }

    public function destroy(Product $product, ProductSpecification $specification): RedirectResponse
    {
        $this->specificationService->delete($specification);
        return redirect()->route('admin.products.specifications.index', $product)
            ->with('success', 'Specification deleted successfully.');
    }
}

