<?php

namespace Modules\Sales\Controllers;

use App\Http\Controllers\Controller;
use Modules\Sales\Services\SalesOrderService;
use Modules\Sales\Requests\StoreSalesOrderRequest;
use Modules\Sales\Requests\UpdateSalesOrderRequest;
use Modules\Sales\Models\SalesOrder;
use Modules\BusinessPartner\Services\BusinessPartnerService;
use Modules\ProductMaster\Services\ProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SalesOrderController extends Controller
{
    public function __construct(
        protected SalesOrderService $salesOrderService,
        protected BusinessPartnerService $businessPartnerService,
        protected ProductService $productService,
    ) {}

    public function index(): View
    {
        $salesOrders = $this->salesOrderService->getPaginated();
        return view('admin.sales.sales-orders.index', compact('salesOrders'));
    }

    public function create(): View
    {
        $customers = $this->businessPartnerService->getAllCustomers();
        $products = $this->productService->getAll();
        return view('admin.sales.sales-orders.create', compact('customers', 'products'));
    }

    public function store(StoreSalesOrderRequest $request): RedirectResponse
    {
        $this->salesOrderService->create($request->validated());
        return redirect()->route('admin.sales.sales-orders.index')
            ->with('success', 'Sales order created successfully.');
    }

    public function show(SalesOrder $salesOrder): View
    {
        $salesOrder->load(['customer', 'items.product', 'approver']);
        return view('admin.sales.sales-orders.show', compact('salesOrder'));
    }

    public function edit(SalesOrder $salesOrder): View
    {
        $customers = $this->businessPartnerService->getAllCustomers();
        $products = $this->productService->getAll();
        $salesOrder->load('items');
        return view('admin.sales.sales-orders.edit', compact('salesOrder', 'customers', 'products'));
    }

    public function update(UpdateSalesOrderRequest $request, SalesOrder $salesOrder): RedirectResponse
    {
        $this->salesOrderService->update($salesOrder, $request->validated());
        return redirect()->route('admin.sales.sales-orders.index')
            ->with('success', 'Sales order updated successfully.');
    }

    public function destroy(SalesOrder $salesOrder): RedirectResponse
    {
        $this->salesOrderService->delete($salesOrder);
        return redirect()->route('admin.sales.sales-orders.index')
            ->with('success', 'Sales order deleted successfully.');
    }

    public function submit(SalesOrder $salesOrder): RedirectResponse
    {
        $this->salesOrderService->submit($salesOrder);
        return redirect()->route('admin.sales.sales-orders.index')
            ->with('success', 'Sales order submitted successfully.');
    }

    public function approve(SalesOrder $salesOrder): RedirectResponse
    {
        $this->salesOrderService->approve($salesOrder);
        return redirect()->route('admin.sales.sales-orders.index')
            ->with('success', 'Sales order approved successfully.');
    }

    public function cancel(SalesOrder $salesOrder): RedirectResponse
    {
        $this->salesOrderService->cancel($salesOrder);
        return redirect()->route('admin.sales.sales-orders.index')
            ->with('success', 'Sales order cancelled.');
    }
}

