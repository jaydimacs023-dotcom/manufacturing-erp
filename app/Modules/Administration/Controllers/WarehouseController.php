<?php

namespace Modules\Administration\Controllers;

use App\Http\Controllers\Controller;
use Modules\Administration\Models\Warehouse;
use Modules\Administration\Requests\StoreWarehouseRequest;
use Modules\Administration\Requests\UpdateWarehouseRequest;
use Modules\Administration\Services\WarehouseService;
use Modules\Administration\Services\BranchService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WarehouseController extends Controller
{
    public function __construct(
        protected WarehouseService $warehouseService,
        protected BranchService $branchService,
    ) {}

    public function index(): View
    {
        $warehouses = $this->warehouseService->getPaginated();
        return view('admin.warehouses.index', compact('warehouses'));
    }

    public function create(): View
    {
        $branches = $this->branchService->getActiveBranches();
        return view('admin.warehouses.create', compact('branches'));
    }

    public function store(StoreWarehouseRequest $request): RedirectResponse
    {
        $this->warehouseService->create($request->validated());
        return redirect()->route('admin.warehouses.index')
            ->with('success', 'Warehouse created successfully.');
    }

    public function show(Warehouse $warehouse): View
    {
        return view('admin.warehouses.show', compact('warehouse'));
    }

    public function edit(Warehouse $warehouse): View
    {
        $branches = $this->branchService->getActiveBranches();
        return view('admin.warehouses.edit', compact('warehouse', 'branches'));
    }

    public function update(UpdateWarehouseRequest $request, Warehouse $warehouse): RedirectResponse
    {
        $this->warehouseService->update($warehouse, $request->validated());
        return redirect()->route('admin.warehouses.index')
            ->with('success', 'Warehouse updated successfully.');
    }

    public function destroy(Warehouse $warehouse): RedirectResponse
    {
        $this->warehouseService->delete($warehouse);
        return redirect()->route('admin.warehouses.index')
            ->with('success', 'Warehouse deleted successfully.');
    }
}

