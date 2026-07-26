<?php

namespace Modules\BusinessPartner\Controllers;

use App\Http\Controllers\Controller;
use Modules\BusinessPartner\Models\BusinessPartner;
use Modules\BusinessPartner\Requests\StoreBusinessPartnerRequest;
use Modules\BusinessPartner\Requests\UpdateBusinessPartnerRequest;
use Modules\BusinessPartner\Services\BusinessPartnerService;
use Modules\BusinessPartner\Services\PaymentTermService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BusinessPartnerController extends Controller
{
    public function __construct(
        protected BusinessPartnerService $businessPartnerService,
        protected PaymentTermService $paymentTermService,
    ) {}

    public function index(): View
    {
        $businessPartners = $this->businessPartnerService->getPaginated();
        return view('admin.business-partners.index', compact('businessPartners'));
    }

    public function create(): View
    {
        $paymentTerms = $this->paymentTermService->getActiveTerms();
        $partnerTypes = [
            'supplier' => 'Supplier',
            'customer' => 'Customer',
            'freight_forwarder' => 'Freight Forwarder',
            'customs_broker' => 'Customs Broker',
            'service_provider' => 'Service Provider',
        ];
        return view('admin.business-partners.create', compact('paymentTerms', 'partnerTypes'));
    }

    public function store(StoreBusinessPartnerRequest $request): RedirectResponse
    {
        $this->businessPartnerService->create($request->validated());
        return redirect()->route('admin.business-partners.index')
            ->with('success', 'Business partner created successfully.');
    }

    public function show(BusinessPartner $businessPartner): View
    {
        $businessPartner->load(['paymentTerm', 'contactPersons']);
        return view('admin.business-partners.show', compact('businessPartner'));
    }

    public function edit(BusinessPartner $businessPartner): View
    {
        $paymentTerms = $this->paymentTermService->getActiveTerms();
        $partnerTypes = [
            'supplier' => 'Supplier',
            'customer' => 'Customer',
            'freight_forwarder' => 'Freight Forwarder',
            'customs_broker' => 'Customs Broker',
            'service_provider' => 'Service Provider',
        ];
        return view('admin.business-partners.edit', compact('businessPartner', 'paymentTerms', 'partnerTypes'));
    }

    public function update(UpdateBusinessPartnerRequest $request, BusinessPartner $businessPartner): RedirectResponse
    {
        $this->businessPartnerService->update($businessPartner, $request->validated());
        return redirect()->route('admin.business-partners.index')
            ->with('success', 'Business partner updated successfully.');
    }

    public function destroy(BusinessPartner $businessPartner): RedirectResponse
    {
        $this->businessPartnerService->delete($businessPartner);
        return redirect()->route('admin.business-partners.index')
            ->with('success', 'Business partner deleted successfully.');
    }
}
