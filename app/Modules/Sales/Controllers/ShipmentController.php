<?php

namespace Modules\Sales\Controllers;

use App\Http\Controllers\Controller;
use Modules\Sales\Services\ShipmentService;
use Modules\Sales\Requests\StorePackingListRequest;
use Modules\Sales\Requests\StoreCommercialInvoiceRequest;
use Modules\Sales\Models\PackingList;
use Modules\Sales\Models\CommercialInvoice;
use Modules\Sales\Models\ExportOrder;
use Modules\ProductMaster\Services\ProductService;
use Modules\BusinessPartner\Services\BusinessPartnerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ShipmentController extends Controller
{
    public function __construct(
        protected ShipmentService $shipmentService,
        protected ProductService $productService,
        protected BusinessPartnerService $businessPartnerService,
    ) {}

    public function index(): View
    {
        $packingLists = $this->shipmentService->getPackingListsPaginated();
        $invoices = $this->shipmentService->getInvoicesPaginated(10);
        return view('admin.sales.shipments.index', compact('packingLists', 'invoices'));
    }

    public function createPackingList(): View
    {
        $exportOrders = ExportOrder::whereNotIn('status', ['cancelled', 'delivered'])->get();
        $products = $this->productService->getAll();
        return view('admin.sales.shipments.create-packing-list', compact('exportOrders', 'products'));
    }

    public function storePackingList(StorePackingListRequest $request): RedirectResponse
    {
        $this->shipmentService->createPackingList($request->validated());
        return redirect()->route('admin.sales.shipments.index')
            ->with('success', 'Packing list created successfully.');
    }

    public function showPackingList(PackingList $packingList): View
    {
        $packingList->load(['exportOrder', 'product']);
        return view('admin.sales.shipments.show-packing-list', compact('packingList'));
    }

    public function destroyPackingList(PackingList $packingList): RedirectResponse
    {
        $this->shipmentService->deletePackingList($packingList);
        return redirect()->route('admin.sales.shipments.index')
            ->with('success', 'Packing list deleted successfully.');
    }

    public function createInvoice(): View
    {
        $exportOrders = ExportOrder::whereNotIn('status', ['cancelled', 'delivered'])->get();
        $customers = $this->businessPartnerService->getAllCustomers();
        return view('admin.sales.shipments.create-invoice', compact('exportOrders', 'customers'));
    }

    public function storeInvoice(StoreCommercialInvoiceRequest $request): RedirectResponse
    {
        $this->shipmentService->createCommercialInvoice($request->validated());
        return redirect()->route('admin.sales.shipments.index')
            ->with('success', 'Commercial invoice created successfully.');
    }

    public function showInvoice(CommercialInvoice $commercialInvoice): View
    {
        $commercialInvoice->load(['exportOrder', 'customer']);
        return view('admin.sales.shipments.show-invoice', compact('commercialInvoice'));
    }

    public function destroyInvoice(CommercialInvoice $commercialInvoice): RedirectResponse
    {
        $this->shipmentService->deleteCommercialInvoice($commercialInvoice);
        return redirect()->route('admin.sales.shipments.index')
            ->with('success', 'Commercial invoice deleted successfully.');
    }
}

