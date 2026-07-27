<?php

namespace Modules\Manufacturing\Controllers;

use App\Http\Controllers\Controller;
use Modules\Manufacturing\Models\BillOfMaterial;
use Modules\Manufacturing\Requests\StoreBillOfMaterialRequest;
use Modules\Manufacturing\Requests\UpdateBillOfMaterialRequest;
use Modules\Manufacturing\Services\BillOfMaterialService;
use Modules\ProductMaster\Services\ProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BillOfMaterialController extends Controller
{
    public function __construct(
        protected BillOfMaterialService $bomService,
        protected ProductService $productService,
    ) {}

    public function index(): View
    {
        $boms = $this->bomService->getPaginated();
        return view('admin.manufacturing.bom.index', compact('boms'));
    }

    public function create(): View
    {
        $products = $this->productService->getAll();
        return view('admin.manufacturing.bom.create', compact('products'));
    }

    public function store(StoreBillOfMaterialRequest $request): RedirectResponse
    {
        $this->bomService->create($request->validated());
        return redirect()->route('admin.manufacturing.bom.index')
            ->with('success', 'Bill of Materials created successfully.');
    }

    public function show(BillOfMaterial $billOfMaterial): View
    {
        $billOfMaterial->load(['product', 'uom', 'items.product', 'items.uom']);
        return view('admin.manufacturing.bom.show', compact('billOfMaterial'));
    }

    public function edit(BillOfMaterial $billOfMaterial): View
    {
        $products = $this->productService->getAll();
        $billOfMaterial->load('items');
        return view('admin.manufacturing.bom.edit', compact('billOfMaterial', 'products'));
    }

    public function update(UpdateBillOfMaterialRequest $request, BillOfMaterial $billOfMaterial): RedirectResponse
    {
        $this->bomService->update($billOfMaterial, $request->validated());
        return redirect()->route('admin.manufacturing.bom.index')
            ->with('success', 'Bill of Materials updated successfully.');
    }

    public function destroy(BillOfMaterial $billOfMaterial): RedirectResponse
    {
        $this->bomService->delete($billOfMaterial);
        return redirect()->route('admin.manufacturing.bom.index')
            ->with('success', 'Bill of Materials deleted successfully.');
    }

    public function approve(BillOfMaterial $billOfMaterial): RedirectResponse
    {
        $this->bomService->approve($billOfMaterial);
        return redirect()->route('admin.manufacturing.bom.index')
            ->with('success', 'Bill of Materials approved successfully.');
    }
}
