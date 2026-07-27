<?php

namespace Modules\Procurement\Controllers;

use App\Http\Controllers\Controller;
use Modules\Procurement\Models\PurchaseRequest;
use Modules\Procurement\Requests\StorePurchaseRequestRequest;
use Modules\Procurement\Requests\UpdatePurchaseRequestRequest;
use Modules\Procurement\Services\PurchaseRequestService;
use Modules\Administration\Services\DepartmentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PurchaseRequestController extends Controller
{
    public function __construct(
        protected PurchaseRequestService $purchaseRequestService,
        protected DepartmentService $departmentService,
    ) {}

    public function index(): View
    {
        $purchaseRequests = $this->purchaseRequestService->getPaginated();
        return view('admin.purchase-requests.index', compact('purchaseRequests'));
    }

    public function create(): View
    {
        $departments = $this->departmentService->getAll();
        $priorities = [
            'low' => 'Low',
            'normal' => 'Normal',
            'high' => 'High',
            'urgent' => 'Urgent',
        ];
        return view('admin.purchase-requests.create', compact('departments', 'priorities'));
    }

    public function store(StorePurchaseRequestRequest $request): RedirectResponse
    {
        $this->purchaseRequestService->create($request->validated());
        return redirect()->route('admin.purchase-requests.index')
            ->with('success', 'Purchase request created successfully.');
    }

    public function show(PurchaseRequest $purchaseRequest): View
    {
        $purchaseRequest->load(['department', 'items.product', 'items.uom', 'purchaseOrders']);
        return view('admin.purchase-requests.show', compact('purchaseRequest'));
    }

    public function edit(PurchaseRequest $purchaseRequest): View
    {
        $departments = $this->departmentService->getAll();
        $priorities = [
            'low' => 'Low',
            'normal' => 'Normal',
            'high' => 'High',
            'urgent' => 'Urgent',
        ];
        return view('admin.purchase-requests.edit', compact('purchaseRequest', 'departments', 'priorities'));
    }

    public function update(UpdatePurchaseRequestRequest $request, PurchaseRequest $purchaseRequest): RedirectResponse
    {
        $this->purchaseRequestService->update($purchaseRequest, $request->validated());
        return redirect()->route('admin.purchase-requests.index')
            ->with('success', 'Purchase request updated successfully.');
    }

    public function destroy(PurchaseRequest $purchaseRequest): RedirectResponse
    {
        $this->purchaseRequestService->delete($purchaseRequest);
        return redirect()->route('admin.purchase-requests.index')
            ->with('success', 'Purchase request deleted successfully.');
    }

    public function approve(PurchaseRequest $purchaseRequest): RedirectResponse
    {
        $this->purchaseRequestService->approve($purchaseRequest);
        return redirect()->route('admin.purchase-requests.index')
            ->with('success', 'Purchase request approved successfully.');
    }

    public function reject(PurchaseRequest $purchaseRequest): RedirectResponse
    {
        $this->purchaseRequestService->reject($purchaseRequest);
        return redirect()->route('admin.purchase-requests.index')
            ->with('success', 'Purchase request rejected successfully.');
    }

    public function submit(PurchaseRequest $purchaseRequest): RedirectResponse
    {
        $this->purchaseRequestService->submit($purchaseRequest);
        return redirect()->route('admin.purchase-requests.index')
            ->with('success', 'Purchase request submitted successfully.');
    }

    public function cancel(PurchaseRequest $purchaseRequest): RedirectResponse
    {
        $this->purchaseRequestService->cancel($purchaseRequest);
        return redirect()->route('admin.purchase-requests.index')
            ->with('success', 'Purchase request cancelled successfully.');
    }
}

