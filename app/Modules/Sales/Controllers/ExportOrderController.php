<?php

namespace Modules\Sales\Controllers;

use App\Http\Controllers\Controller;
use Modules\Sales\Services\ExportOrderService;
use Modules\Sales\Requests\StoreExportOrderRequest;
use Modules\Sales\Requests\UpdateExportOrderRequest;
use Modules\Sales\Models\ExportOrder;
use Modules\BusinessPartner\Services\BusinessPartnerService;
use Modules\Sales\Services\SalesOrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ExportOrderController extends Controller
{
    public function __construct(
        protected ExportOrderService $exportOrderService,
        protected BusinessPartnerService $businessPartnerService,
        protected SalesOrderService $salesOrderService,
    ) {}

    public function index(): View
    {
        $exportOrders = $this->exportOrderService->getPaginated();
        return view('admin.sales.export-orders.index', compact('exportOrders'));
    }

    public function create(): View
    {
        $customers = $this->businessPartnerService->getAllCustomers();
        $salesOrders = $this->salesOrderService->getPaginated(100);
        return view('admin.sales.export-orders.create', compact('customers', 'salesOrders'));
    }

    public function store(StoreExportOrderRequest $request): RedirectResponse
    {
        $this->exportOrderService->create($request->validated());
        return redirect()->route('admin.sales.export-orders.index')
            ->with('success', 'Export order created successfully.');
    }

    public function show(ExportOrder $exportOrder): View
    {
        $exportOrder->load(['customer', 'items.product', 'items.salesOrder', 'approver', 'packingLists', 'commercialInvoices']);
        return view('admin.sales.export-orders.show', compact('exportOrder'));
    }

    public function edit(ExportOrder $exportOrder): View
    {
        $customers = $this->businessPartnerService->getAllCustomers();
        $salesOrders = $this->salesOrderService->getPaginated(100);
        $exportOrder->load('items');
        return view('admin.sales.export-orders.edit', compact('exportOrder', 'customers', 'salesOrders'));
    }

    public function update(UpdateExportOrderRequest $request, ExportOrder $exportOrder): RedirectResponse
    {
        $this->exportOrderService->update($exportOrder, $request->validated());
        return redirect()->route('admin.sales.export-orders.index')
            ->with('success', 'Export order updated successfully.');
    }

    public function destroy(ExportOrder $exportOrder): RedirectResponse
    {
        $this->exportOrderService->delete($exportOrder);
        return redirect()->route('admin.sales.export-orders.index')
            ->with('success', 'Export order deleted successfully.');
    }

    public function approve(ExportOrder $exportOrder): RedirectResponse
    {
        $this->exportOrderService->approve($exportOrder);
        return redirect()->route('admin.sales.export-orders.index')
            ->with('success', 'Export order approved.');
    }

    public function load(ExportOrder $exportOrder): RedirectResponse
    {
        $this->exportOrderService->markLoaded($exportOrder);
        return redirect()->route('admin.sales.export-orders.index')
            ->with('success', 'Export order marked as loaded.');
    }

    public function dispatch(ExportOrder $exportOrder): RedirectResponse
    {
        $this->exportOrderService->dispatch($exportOrder);
        return redirect()->route('admin.sales.export-orders.index')
            ->with('success', 'Export order dispatched.');
    }

    public function markInTransit(ExportOrder $exportOrder): RedirectResponse
    {
        $this->exportOrderService->markInTransit($exportOrder);
        return redirect()->route('admin.sales.export-orders.index')
            ->with('success', 'Export order marked in transit.');
    }

    public function markDelivered(ExportOrder $exportOrder): RedirectResponse
    {
        $this->exportOrderService->markDelivered($exportOrder);
        return redirect()->route('admin.sales.export-orders.index')
            ->with('success', 'Export order delivered.');
    }

    public function cancel(ExportOrder $exportOrder): RedirectResponse
    {
        $this->exportOrderService->cancel($exportOrder);
        return redirect()->route('admin.sales.export-orders.index')
            ->with('success', 'Export order cancelled.');
    }
}

