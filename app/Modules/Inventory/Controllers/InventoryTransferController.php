<?php

namespace Modules\Inventory\Controllers;

use App\Http\Controllers\Controller;
use Modules\Inventory\Models\InventoryTransfer;
use Modules\Inventory\Requests\StoreInventoryTransferRequest;
use Modules\Inventory\Requests\UpdateInventoryTransferRequest;
use Modules\Inventory\Services\InventoryTransferService;
use Modules\Administration\Services\WarehouseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class InventoryTransferController extends Controller
{
    public function __construct(
        protected InventoryTransferService $transferService,
        protected WarehouseService $warehouseService,
    ) {}

    public function index(): View
    {
        $transfers = $this->transferService->getPaginated();
        return view('admin.inventory.transfers.index', compact('transfers'));
    }

    public function create(): View
    {
        $warehouses = $this->warehouseService->getAll();
        return view('admin.inventory.transfers.create', compact('warehouses'));
    }

    public function store(StoreInventoryTransferRequest $request): RedirectResponse
    {
        $this->transferService->create($request->validated());
        return redirect()->route('admin.inventory.transfers.index')
            ->with('success', 'Inventory transfer created successfully.');
    }

    public function show(InventoryTransfer $inventoryTransfer): View
    {
        $inventoryTransfer->load(['fromWarehouse', 'toWarehouse', 'items.product', 'items.uom']);
        return view('admin.inventory.transfers.show', compact('inventoryTransfer'));
    }

    public function edit(InventoryTransfer $inventoryTransfer): View
    {
        $warehouses = $this->warehouseService->getAll();
        return view('admin.inventory.transfers.edit', compact('inventoryTransfer', 'warehouses'));
    }

    public function update(UpdateInventoryTransferRequest $request, InventoryTransfer $inventoryTransfer): RedirectResponse
    {
        $this->transferService->update($inventoryTransfer, $request->validated());
        return redirect()->route('admin.inventory.transfers.index')
            ->with('success', 'Inventory transfer updated successfully.');
    }

    public function destroy(InventoryTransfer $inventoryTransfer): RedirectResponse
    {
        $this->transferService->delete($inventoryTransfer);
        return redirect()->route('admin.inventory.transfers.index')
            ->with('success', 'Inventory transfer deleted successfully.');
    }

    public function complete(InventoryTransfer $inventoryTransfer): RedirectResponse
    {
        $this->transferService->complete($inventoryTransfer);
        return redirect()->route('admin.inventory.transfers.index')
            ->with('success', 'Transfer completed successfully.');
    }

    public function cancel(InventoryTransfer $inventoryTransfer): RedirectResponse
    {
        $this->transferService->cancel($inventoryTransfer);
        return redirect()->route('admin.inventory.transfers.index')
            ->with('success', 'Transfer cancelled successfully.');
    }
}
