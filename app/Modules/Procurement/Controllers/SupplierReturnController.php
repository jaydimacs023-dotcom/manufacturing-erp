<?php

namespace Modules\Procurement\Controllers;

use App\Http\Controllers\Controller;
use Modules\Procurement\Models\SupplierReturn;
use Modules\Procurement\Requests\StoreSupplierReturnRequest;
use Modules\Procurement\Requests\UpdateSupplierReturnRequest;
use Modules\Procurement\Services\SupplierReturnService;
use Modules\Procurement\Services\GoodsReceiptService;
use Modules\Administration\Services\WarehouseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SupplierReturnController extends Controller
{
    public function __construct(
        protected SupplierReturnService $supplierReturnService,
        protected GoodsReceiptService $goodsReceiptService,
        protected WarehouseService $warehouseService,
    ) {}

    public function index(): View
    {
        $supplierReturns = $this->supplierReturnService->getPaginated();
        return view('admin.supplier-returns.index', compact('supplierReturns'));
    }

    public function create(): View
    {
        $goodsReceipts = $this->goodsReceiptService->getPaginated();
        $warehouses = $this->warehouseService->getAll();
        $reasons = [
            'damaged_packaging' => 'Damaged Packaging',
            'spoiled_goods' => 'Spoiled Goods',
            'incorrect_quantity' => 'Incorrect Quantity',
            'wrong_item' => 'Wrong Item',
            'failed_quality_inspection' => 'Failed Quality Inspection',
            'other' => 'Other',
        ];
        return view('admin.supplier-returns.create', compact('goodsReceipts', 'warehouses', 'reasons'));
    }

    public function store(StoreSupplierReturnRequest $request): RedirectResponse
    {
        $this->supplierReturnService->create($request->validated());
        return redirect()->route('admin.supplier-returns.index')
            ->with('success', 'Supplier return created successfully.');
    }

    public function show(SupplierReturn $supplierReturn): View
    {
        $supplierReturn->load(['goodsReceipt.purchaseOrder', 'warehouse', 'items.product', 'items.uom']);
        return view('admin.supplier-returns.show', compact('supplierReturn'));
    }

    public function edit(SupplierReturn $supplierReturn): View
    {
        $goodsReceipts = $this->goodsReceiptService->getPaginated();
        $warehouses = $this->warehouseService->getAll();
        $reasons = [
            'damaged_packaging' => 'Damaged Packaging',
            'spoiled_goods' => 'Spoiled Goods',
            'incorrect_quantity' => 'Incorrect Quantity',
            'wrong_item' => 'Wrong Item',
            'failed_quality_inspection' => 'Failed Quality Inspection',
            'other' => 'Other',
        ];
        return view('admin.supplier-returns.edit', compact('supplierReturn', 'goodsReceipts', 'warehouses', 'reasons'));
    }

    public function update(UpdateSupplierReturnRequest $request, SupplierReturn $supplierReturn): RedirectResponse
    {
        $this->supplierReturnService->update($supplierReturn, $request->validated());
        return redirect()->route('admin.supplier-returns.index')
            ->with('success', 'Supplier return updated successfully.');
    }

    public function destroy(SupplierReturn $supplierReturn): RedirectResponse
    {
        $this->supplierReturnService->delete($supplierReturn);
        return redirect()->route('admin.supplier-returns.index')
            ->with('success', 'Supplier return deleted successfully.');
    }

    public function complete(SupplierReturn $supplierReturn): RedirectResponse
    {
        $this->supplierReturnService->complete($supplierReturn);
        return redirect()->route('admin.supplier-returns.index')
            ->with('success', 'Supplier return completed successfully.');
    }

    public function cancel(SupplierReturn $supplierReturn): RedirectResponse
    {
        $this->supplierReturnService->cancel($supplierReturn);
        return redirect()->route('admin.supplier-returns.index')
            ->with('success', 'Supplier return cancelled successfully.');
    }
}

