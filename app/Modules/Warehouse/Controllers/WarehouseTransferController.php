<?php

namespace Modules\Warehouse\Controllers;

use App\Http\Controllers\Controller;
use Modules\Warehouse\Services\WarehouseTransferService;
use Modules\Warehouse\Repositories\StorageLocationRepository;
use Modules\Warehouse\Requests\StoreWarehouseTransferRequest;
use Modules\Warehouse\Models\WarehouseTransfer;
use Modules\ProductMaster\Services\ProductService;
use Modules\Administration\Services\WarehouseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WarehouseTransferController extends Controller
{
    public function __construct(
        protected WarehouseTransferService $transferService,
        protected ProductService $productService,
        protected WarehouseService $warehouseService,
        protected StorageLocationRepository $locationRepository,
    ) {}

    public function index(): View
    {
        $transfers = $this->transferService->getPaginated();
        return view('admin.warehouse.transfers.index', compact('transfers'));
    }

    public function create(): View
    {
        $products = $this->productService->getAll();
        $warehouses = $this->warehouseService->getAll();
        $locations = [];
        return view('admin.warehouse.transfers.create', compact('products', 'warehouses', 'locations'));
    }

    public function store(StoreWarehouseTransferRequest $request): RedirectResponse
    {
        $this->transferService->create($request->validated());
        return redirect()->route('admin.warehouse.transfers.index')
            ->with('success', 'Warehouse transfer created successfully.');
    }

    public function show(WarehouseTransfer $warehouseTransfer): View
    {
        $warehouseTransfer->load([
            'sourceWarehouse', 'sourceLocation',
            'destinationWarehouse', 'destinationLocation',
            'product',
        ]);
        return view('admin.warehouse.transfers.show', compact('warehouseTransfer'));
    }

    public function approve(WarehouseTransfer $warehouseTransfer): RedirectResponse
    {
        $this->transferService->approve($warehouseTransfer);
        return redirect()->route('admin.warehouse.transfers.index')
            ->with('success', 'Transfer approved successfully.');
    }

    public function complete(WarehouseTransfer $warehouseTransfer): RedirectResponse
    {
        $this->transferService->complete($warehouseTransfer);
        return redirect()->route('admin.warehouse.transfers.index')
            ->with('success', 'Transfer completed successfully.');
    }

    public function cancel(WarehouseTransfer $warehouseTransfer): RedirectResponse
    {
        $this->transferService->cancel($warehouseTransfer);
        return redirect()->route('admin.warehouse.transfers.index')
            ->with('success', 'Transfer cancelled.');
    }
}

