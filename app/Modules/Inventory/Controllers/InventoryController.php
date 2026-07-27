<?php

namespace Modules\Inventory\Controllers;

use App\Http\Controllers\Controller;
use Modules\Inventory\Services\InventoryService;
use Modules\ProductMaster\Services\ProductService;
use Modules\Administration\Services\WarehouseService;
use Illuminate\View\View;

class InventoryController extends Controller
{
    public function __construct(
        protected InventoryService $inventoryService,
        protected ProductService $productService,
        protected WarehouseService $warehouseService,
    ) {}

    public function index(): View
    {
        $overview = $this->inventoryService->getInventoryOverview();
        $stockCards = $this->inventoryService->getStockCards();
        $lowStockItems = $this->inventoryService->getLowStock();
        $expiringItems = $this->inventoryService->getExpiring();
        $warehouses = $this->warehouseService->getAll();

        return view('admin.inventory.index', compact(
            'overview', 'stockCards', 'lowStockItems', 'expiringItems', 'warehouses'
        ));
    }

    public function stockCard(int $productId, ?int $warehouseId = null): View
    {
        $product = $this->productService->findById($productId);
        $stockCards = $this->inventoryService->getStockCardByProduct($productId, $warehouseId);
        $movements = $this->inventoryService->getProductMovements($productId);
        $warehouses = $this->warehouseService->getAll();

        return view('admin.inventory.stock-card', compact(
            'product', 'stockCards', 'movements', 'warehouses'
        ));
    }

    public function movements(): View
    {
        $movements = $this->inventoryService->getMovements();
        return view('admin.inventory.movements', compact('movements'));
    }
}
