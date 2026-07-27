<?php

namespace Modules\Warehouse\Controllers;

use App\Http\Controllers\Controller;
use Modules\Warehouse\Services\PutawayService;
use Modules\ProductMaster\Services\ProductService;
use Modules\Administration\Services\WarehouseService;
use Modules\Warehouse\Repositories\StorageLocationRepository;
use Modules\Warehouse\Requests\StorePutawayRequest;
use Modules\Warehouse\Models\Putaway;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PutawayController extends Controller
{
    public function __construct(
        protected PutawayService $putawayService,
        protected ProductService $productService,
        protected WarehouseService $warehouseService,
        protected StorageLocationRepository $locationRepository,
    ) {}

    public function index(): View
    {
        $putaways = $this->warehouseService->getAll();
        // Override to use putaway pagination
        $putaways = $this->putawayService->getPaginated();
        return view('admin.warehouse.putaway.index', compact('putaways'));
    }

    public function create(): View
    {
        $products = $this->productService->getAll();
        $warehouses = $this->warehouseService->getAll();
        $locations = [];
        return view('admin.warehouse.putaway.create', compact('products', 'warehouses', 'locations'));
    }

    public function store(StorePutawayRequest $request): RedirectResponse
    {
        $this->putawayService->create($request->validated());
        return redirect()->route('admin.warehouse.putaway.index')
            ->with('success', 'Put-away created successfully.');
    }

    public function show(Putaway $putaway): View
    {
        $putaway->load(['warehouse', 'storageLocation', 'product']);
        return view('admin.warehouse.putaway.show', compact('putaway'));
    }

    public function complete(Putaway $putaway): RedirectResponse
    {
        $this->putawayService->complete($putaway);
        return redirect()->route('admin.warehouse.putaway.index')
            ->with('success', 'Put-away completed successfully.');
    }

    public function cancel(Putaway $putaway): RedirectResponse
    {
        $this->putawayService->cancel($putaway);
        return redirect()->route('admin.warehouse.putaway.index')
            ->with('success', 'Put-away cancelled.');
    }

    public function getLocationsByWarehouse(int $warehouseId)
    {
        $locations = $this->locationRepository->findByWarehouse($warehouseId);
        return response()->json($locations);
    }
}

