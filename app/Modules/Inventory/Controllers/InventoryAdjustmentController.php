<?php

namespace Modules\Inventory\Controllers;

use App\Http\Controllers\Controller;
use Modules\Inventory\Models\InventoryAdjustment;
use Modules\Inventory\Requests\StoreInventoryAdjustmentRequest;
use Modules\Inventory\Requests\UpdateInventoryAdjustmentRequest;
use Modules\Inventory\Services\InventoryAdjustmentService;
use Modules\Administration\Services\WarehouseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InventoryAdjustmentController extends Controller
{
    public function __construct(
        protected InventoryAdjustmentService $adjustmentService,
        protected WarehouseService $warehouseService,
    ) {}

    public function index(): View
    {
        $adjustments = $this->adjustmentService->getPaginated();
        return view('admin.inventory.adjustments.index', compact('adjustments'));
    }

    public function create(): View
    {
        $warehouses = $this->warehouseService->getAll();
        return view('admin.inventory.adjustments.create', compact('warehouses'));
    }

    public function store(StoreInventoryAdjustmentRequest $request): RedirectResponse
    {
        $this->adjustmentService->create($request->validated());
        return redirect()->route('admin.inventory.adjustments.index')
            ->with('success', 'Inventory adjustment created successfully.');
    }

    public function show(InventoryAdjustment $inventoryAdjustment): View
    {
        $inventoryAdjustment->load(['warehouse', 'items.product', 'items.uom']);
        return view('admin.inventory.adjustments.show', compact('inventoryAdjustment'));
    }

    public function edit(InventoryAdjustment $inventoryAdjustment): View
    {
        $warehouses = $this->warehouseService->getAll();
        return view('admin.inventory.adjustments.edit', compact('inventoryAdjustment', 'warehouses'));
    }

    public function update(UpdateInventoryAdjustmentRequest $request, InventoryAdjustment $inventoryAdjustment): RedirectResponse
    {
        $this->adjustmentService->update($inventoryAdjustment, $request->validated());
        return redirect()->route('admin.inventory.adjustments.index')
            ->with('success', 'Inventory adjustment updated successfully.');
    }

    public function destroy(InventoryAdjustment $inventoryAdjustment): RedirectResponse
    {
        $this->adjustmentService->delete($inventoryAdjustment);
        return redirect()->route('admin.inventory.adjustments.index')
            ->with('success', 'Inventory adjustment deleted successfully.');
    }

    public function submit(InventoryAdjustment $inventoryAdjustment): RedirectResponse
    {
        $this->adjustmentService->submit($inventoryAdjustment);
        return redirect()->route('admin.inventory.adjustments.index')
            ->with('success', 'Adjustment submitted for approval.');
    }

    public function approve(Request $request, InventoryAdjustment $inventoryAdjustment): RedirectResponse
    {
        $this->adjustmentService->approve($inventoryAdjustment, $request->input('remarks'));
        return redirect()->route('admin.inventory.adjustments.index')
            ->with('success', 'Adjustment approved and stock updated.');
    }

    public function reject(Request $request, InventoryAdjustment $inventoryAdjustment): RedirectResponse
    {
        $request->validate(['rejection_reason' => 'required|string|max:500']);
        $this->adjustmentService->reject($inventoryAdjustment, $request->input('rejection_reason'));
        return redirect()->route('admin.inventory.adjustments.index')
            ->with('success', 'Adjustment rejected.');
    }

    public function cancel(InventoryAdjustment $inventoryAdjustment): RedirectResponse
    {
        $this->adjustmentService->cancel($inventoryAdjustment);
        return redirect()->route('admin.inventory.adjustments.index')
            ->with('success', 'Adjustment cancelled successfully.');
    }
}
