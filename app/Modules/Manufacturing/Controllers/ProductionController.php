<?php

namespace Modules\Manufacturing\Controllers;

use App\Http\Controllers\Controller;
use Modules\Manufacturing\Models\ProductionOutput;
use Modules\Manufacturing\Requests\StoreMaterialIssueRequest;
use Modules\Manufacturing\Requests\StoreProductionOutputRequest;
use Modules\Manufacturing\Requests\StoreWasteRecordRequest;
use Modules\Manufacturing\Services\ProductionService;
use Modules\Manufacturing\Services\ManufacturingOrderService;
use Modules\Administration\Services\WarehouseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductionController extends Controller
{
    public function __construct(
        protected ProductionService $productionService,
        protected ManufacturingOrderService $moService,
        protected WarehouseService $warehouseService,
    ) {}

    public function index(): View
    {
        $materialIssues = $this->productionService->getPaginated();
        $outputs = $this->productionService->getOutputsPaginated();
        $wastes = $this->productionService->getWastePaginated();
        $pendingQc = $this->productionService->getOutputsPaginated(10);
        return view('admin.manufacturing.production.index', compact('materialIssues', 'outputs', 'wastes', 'pendingQc'));
    }

    public function show(int $moId): View
    {
        $mo = $this->moService->findById($moId);
        if (!$mo) {
            abort(404);
        }
        $mo->load(['product', 'uom', 'warehouse', 'items.product', 'items.uom']);
        $issues = $this->productionService->getIssuesByMo($moId);
        $outputs = $this->productionService->getOutputsByMo($moId);
        $wastes = $this->productionService->getWasteByMo($moId);
        return view('admin.manufacturing.production.show', compact('mo', 'issues', 'outputs', 'wastes'));
    }

    public function createIssue(): View
    {
        $orders = $this->moService->findPendingProduction();
        $warehouses = $this->warehouseService->getAll();
        return view('admin.manufacturing.production.issue', compact('orders', 'warehouses'));
    }

    public function storeIssue(StoreMaterialIssueRequest $request): RedirectResponse
    {
        $this->productionService->issueMaterials($request->validated());
        return redirect()->route('admin.manufacturing.production.index')
            ->with('success', 'Materials issued successfully.');
    }

    public function createOutput(): View
    {
        $orders = $this->moService->findPendingProduction();
        $warehouses = $this->warehouseService->getAll();
        return view('admin.manufacturing.production.output', compact('orders', 'warehouses'));
    }

    public function storeOutput(StoreProductionOutputRequest $request): RedirectResponse
    {
        $this->productionService->recordOutput($request->validated());
        return redirect()->route('admin.manufacturing.production.index')
            ->with('success', 'Production output recorded successfully.');
    }

    public function approveOutput(ProductionOutput $productionOutput, Request $request): RedirectResponse
    {
        $this->productionService->approveOutput($productionOutput, $request->input('remarks'));
        return redirect()->route('admin.manufacturing.production.index')
            ->with('success', 'Production output approved. Finished goods received.');
    }

    public function rejectOutput(ProductionOutput $productionOutput, Request $request): RedirectResponse
    {
        $request->validate(['reason' => 'required|string|max:500']);
        $this->productionService->rejectOutput($productionOutput, $request->input('reason'));
        return redirect()->route('admin.manufacturing.production.index')
            ->with('success', 'Production output rejected.');
    }

    public function createWaste(): View
    {
        $orders = $this->moService->findPendingProduction();
        $wasteTypes = [
            'banana_peel' => 'Banana Peel',
            'burnt_chips' => 'Burnt Chips',
            'oil_loss' => 'Oil Loss',
            'rejected_product' => 'Rejected Product',
            'packaging_damage' => 'Packaging Damage',
            'other' => 'Other',
        ];
        return view('admin.manufacturing.production.waste', compact('orders', 'wasteTypes'));
    }

    public function storeWaste(StoreWasteRecordRequest $request): RedirectResponse
    {
        $this->productionService->recordWaste($request->validated());
        return redirect()->route('admin.manufacturing.production.index')
            ->with('success', 'Waste record added successfully.');
    }
}
