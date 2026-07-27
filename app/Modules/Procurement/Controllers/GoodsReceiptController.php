<?php

namespace Modules\Procurement\Controllers;

use App\Http\Controllers\Controller;
use Modules\Procurement\Models\GoodsReceipt;
use Modules\Procurement\Requests\StoreGoodsReceiptRequest;
use Modules\Procurement\Requests\UpdateGoodsReceiptRequest;
use Modules\Procurement\Services\GoodsReceiptService;
use Modules\Procurement\Services\PurchaseOrderService;
use Modules\Administration\Services\WarehouseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GoodsReceiptController extends Controller
{
    public function __construct(
        protected GoodsReceiptService $goodsReceiptService,
        protected PurchaseOrderService $purchaseOrderService,
        protected WarehouseService $warehouseService,
    ) {}

    public function index(): View
    {
        $goodsReceipts = $this->goodsReceiptService->getPaginated();
        return view('admin.goods-receipts.index', compact('goodsReceipts'));
    }

    public function create(): View
    {
        $purchaseOrders = $this->purchaseOrderService->findOpen();
        $warehouses = $this->warehouseService->getAll();
        return view('admin.goods-receipts.create', compact('purchaseOrders', 'warehouses'));
    }

    public function store(StoreGoodsReceiptRequest $request): RedirectResponse
    {
        $this->goodsReceiptService->create($request->validated());
        return redirect()->route('admin.goods-receipts.index')
            ->with('success', 'Goods receipt created successfully.');
    }

    public function show(GoodsReceipt $goodsReceipt): View
    {
        $goodsReceipt->load(['purchaseOrder', 'warehouse', 'items.product', 'items.uom', 'supplierReturns']);
        return view('admin.goods-receipts.show', compact('goodsReceipt'));
    }

    public function edit(GoodsReceipt $goodsReceipt): View
    {
        $purchaseOrders = $this->purchaseOrderService->findOpen();
        $warehouses = $this->warehouseService->getAll();
        return view('admin.goods-receipts.edit', compact('goodsReceipt', 'purchaseOrders', 'warehouses'));
    }

    public function update(UpdateGoodsReceiptRequest $request, GoodsReceipt $goodsReceipt): RedirectResponse
    {
        $this->goodsReceiptService->update($goodsReceipt, $request->validated());
        return redirect()->route('admin.goods-receipts.index')
            ->with('success', 'Goods receipt updated successfully.');
    }

    public function destroy(GoodsReceipt $goodsReceipt): RedirectResponse
    {
        $this->goodsReceiptService->delete($goodsReceipt);
        return redirect()->route('admin.goods-receipts.index')
            ->with('success', 'Goods receipt deleted successfully.');
    }

    public function complete(GoodsReceipt $goodsReceipt): RedirectResponse
    {
        $this->goodsReceiptService->complete($goodsReceipt);
        return redirect()->route('admin.goods-receipts.index')
            ->with('success', 'Goods receipt completed successfully.');
    }

    public function cancel(GoodsReceipt $goodsReceipt): RedirectResponse
    {
        $this->goodsReceiptService->cancel($goodsReceipt);
        return redirect()->route('admin.goods-receipts.index')
            ->with('success', 'Goods receipt cancelled successfully.');
    }
}

