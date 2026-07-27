<?php

namespace Modules\Warehouse\Controllers;

use App\Http\Controllers\Controller;
use Modules\Warehouse\Services\PickingService;
use Modules\Warehouse\Requests\StorePickingRequest;
use Modules\Warehouse\Models\Picking;
use Modules\ProductMaster\Services\ProductService;
use Modules\Administration\Services\WarehouseService;
use Modules\Administration\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PickingController extends Controller
{
    public function __construct(
        protected PickingService $pickingService,
        protected ProductService $productService,
        protected WarehouseService $warehouseService,
    ) {}

    public function index(): View
    {
        $pickings = $this->pickingService->getPaginated();
        return view('admin.warehouse.picking.index', compact('pickings'));
    }

    public function create(): View
    {
        $products = $this->productService->getAll();
        $warehouses = $this->warehouseService->getAll();
        $pickingTypes = [
            'production' => 'Production',
            'shipment' => 'Shipment',
            'transfer' => 'Transfer',
        ];
        return view('admin.warehouse.picking.create', compact('products', 'warehouses', 'pickingTypes'));
    }

    public function store(StorePickingRequest $request): RedirectResponse
    {
        $this->pickingService->create($request->validated());
        return redirect()->route('admin.warehouse.picking.index')
            ->with('success', 'Picking created successfully.');
    }

    public function show(Picking $picking): View
    {
        $picking->load(['warehouse', 'items.product', 'items.storageLocation', 'assignedTo']);
        return view('admin.warehouse.picking.show', compact('picking'));
    }

    public function complete(Picking $picking): RedirectResponse
    {
        $this->pickingService->complete($picking);
        return redirect()->route('admin.warehouse.picking.index')
            ->with('success', 'Picking completed successfully.');
    }

    public function cancel(Picking $picking): RedirectResponse
    {
        $this->pickingService->cancel($picking);
        return redirect()->route('admin.warehouse.picking.index')
            ->with('success', 'Picking cancelled.');
    }
}

