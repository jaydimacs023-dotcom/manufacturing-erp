<?php

namespace Modules\Procurement\Controllers;

use App\Http\Controllers\Controller;
use Modules\Procurement\Models\PurchaseOrder;
use Modules\Procurement\Requests\StorePurchaseOrderRequest;
use Modules\Procurement\Requests\UpdatePurchaseOrderRequest;
use Modules\Procurement\Services\PurchaseOrderService;
use Modules\Procurement\Services\PurchaseRequestService;
use Modules\BusinessPartner\Services\BusinessPartnerService;
use Modules\BusinessPartner\Services\PaymentTermService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PurchaseOrderController extends Controller
{
    public function __construct(
        protected PurchaseOrderService $purchaseOrderService,
        protected PurchaseRequestService $purchaseRequestService,
        protected BusinessPartnerService $businessPartnerService,
        protected PaymentTermService $paymentTermService,
    ) {}

    public function index(): View
    {
        $purchaseOrders = $this->purchaseOrderService->getPaginated();
        return view('admin.purchase-orders.index', compact('purchaseOrders'));
    }

    public function create(): View
    {
        $purchaseRequests = $this->purchaseRequestService->getPendingApproval();
        $suppliers = $this->businessPartnerService->getSuppliers();
        $paymentTerms = $this->paymentTermService->getActiveTerms();
        return view('admin.purchase-orders.create', compact('purchaseRequests', 'suppliers', 'paymentTerms'));
    }

    public function store(StorePurchaseOrderRequest $request): RedirectResponse
    {
        $this->purchaseOrderService->create($request->validated());
        return redirect()->route('admin.purchase-orders.index')
            ->with('success', 'Purchase order created successfully.');
    }

    public function show(PurchaseOrder $purchaseOrder): View
    {
        $purchaseOrder->load(['supplier', 'paymentTerm', 'items.product', 'items.uom', 'purchaseRequest', 'goodsReceipts']);
        return view('admin.purchase-orders.show', compact('purchaseOrder'));
    }

    public function edit(PurchaseOrder $purchaseOrder): View
    {
        $purchaseRequests = $this->purchaseRequestService->getPendingApproval();
        $suppliers = $this->businessPartnerService->getSuppliers();
        $paymentTerms = $this->paymentTermService->getActiveTerms();
        return view('admin.purchase-orders.edit', compact('purchaseOrder', 'purchaseRequests', 'suppliers', 'paymentTerms'));
    }

    public function update(UpdatePurchaseOrderRequest $request, PurchaseOrder $purchaseOrder): RedirectResponse
    {
        $this->purchaseOrderService->update($purchaseOrder, $request->validated());
        return redirect()->route('admin.purchase-orders.index')
            ->with('success', 'Purchase order updated successfully.');
    }

    public function destroy(PurchaseOrder $purchaseOrder): RedirectResponse
    {
        $this->purchaseOrderService->delete($purchaseOrder);
        return redirect()->route('admin.purchase-orders.index')
            ->with('success', 'Purchase order deleted successfully.');
    }

    public function approve(PurchaseOrder $purchaseOrder): RedirectResponse
    {
        $this->purchaseOrderService->approve($purchaseOrder);
        return redirect()->route('admin.purchase-orders.index')
            ->with('success', 'Purchase order approved successfully.');
    }

    public function send(PurchaseOrder $purchaseOrder): RedirectResponse
    {
        $this->purchaseOrderService->send($purchaseOrder);
        return redirect()->route('admin.purchase-orders.index')
            ->with('success', 'Purchase order sent to supplier successfully.');
    }

    public function close(PurchaseOrder $purchaseOrder): RedirectResponse
    {
        $this->purchaseOrderService->close($purchaseOrder);
        return redirect()->route('admin.purchase-orders.index')
            ->with('success', 'Purchase order closed successfully.');
    }

    public function cancel(PurchaseOrder $purchaseOrder): RedirectResponse
    {
        $this->purchaseOrderService->cancel($purchaseOrder);
        return redirect()->route('admin.purchase-orders.index')
            ->with('success', 'Purchase order cancelled successfully.');
    }
}

