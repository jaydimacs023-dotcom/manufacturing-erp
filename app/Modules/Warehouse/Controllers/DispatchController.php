<?php

namespace Modules\Warehouse\Controllers;

use App\Http\Controllers\Controller;
use Modules\Warehouse\Services\DispatchService;
use Modules\Warehouse\Requests\StoreDispatchRequest;
use Modules\Warehouse\Models\Dispatch;
use Modules\ProductMaster\Services\ProductService;
use Modules\Administration\Services\WarehouseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DispatchController extends Controller
{
    public function __construct(
        protected DispatchService $dispatchService,
        protected ProductService $productService,
        protected WarehouseService $warehouseService,
    ) {}

    public function index(): View
    {
        $dispatches = $this->dispatchService->getPaginated();
        return view('admin.warehouse.dispatch.index', compact('dispatches'));
    }

    public function create(): View
    {
        $products = $this->productService->getAll();
        $warehouses = $this->warehouseService->getAll();
        $dispatchTypes = [
            'sales' => 'Sales',
            'export' => 'Export',
            'transfer' => 'Transfer',
        ];
        return view('admin.warehouse.dispatch.create', compact('products', 'warehouses', 'dispatchTypes'));
    }

    public function store(StoreDispatchRequest $request): RedirectResponse
    {
        $this->dispatchService->create($request->validated());
        return redirect()->route('admin.warehouse.dispatch.index')
            ->with('success', 'Dispatch created successfully.');
    }

    public function show(Dispatch $dispatch): View
    {
        $dispatch->load(['warehouse', 'product', 'confirmer', 'approver']);
        return view('admin.warehouse.dispatch.show', compact('dispatch'));
    }

    public function pack(Dispatch $dispatch): RedirectResponse
    {
        $this->dispatchService->markPacked($dispatch);
        return redirect()->route('admin.warehouse.dispatch.index')
            ->with('success', 'Dispatch marked as packed.');
    }

    public function load(Dispatch $dispatch): RedirectResponse
    {
        $this->dispatchService->markLoaded($dispatch);
        return redirect()->route('admin.warehouse.dispatch.index')
            ->with('success', 'Dispatch loaded successfully.');
    }

    public function confirm(Dispatch $dispatch): RedirectResponse
    {
        $this->dispatchService->confirmDispatch($dispatch);
        return redirect()->route('admin.warehouse.dispatch.index')
            ->with('success', 'Dispatch confirmed successfully.');
    }

    public function cancel(Dispatch $dispatch): RedirectResponse
    {
        $this->dispatchService->cancel($dispatch);
        return redirect()->route('admin.warehouse.dispatch.index')
            ->with('success', 'Dispatch cancelled.');
    }
}

