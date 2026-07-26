<?php

namespace Modules\BusinessPartner\Controllers;

use App\Http\Controllers\Controller;
use Modules\BusinessPartner\Models\PaymentTerm;
use Modules\BusinessPartner\Requests\StorePaymentTermRequest;
use Modules\BusinessPartner\Requests\UpdatePaymentTermRequest;
use Modules\BusinessPartner\Services\PaymentTermService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PaymentTermController extends Controller
{
    public function __construct(
        protected PaymentTermService $paymentTermService,
    ) {}

    public function index(): View
    {
        $paymentTerms = $this->paymentTermService->getPaginated();
        return view('admin.payment-terms.index', compact('paymentTerms'));
    }

    public function create(): View
    {
        return view('admin.payment-terms.create');
    }

    public function store(StorePaymentTermRequest $request): RedirectResponse
    {
        $this->paymentTermService->create($request->validated());
        return redirect()->route('admin.payment-terms.index')
            ->with('success', 'Payment term created successfully.');
    }

    public function edit(PaymentTerm $paymentTerm): View
    {
        return view('admin.payment-terms.edit', compact('paymentTerm'));
    }

    public function update(UpdatePaymentTermRequest $request, PaymentTerm $paymentTerm): RedirectResponse
    {
        $this->paymentTermService->update($paymentTerm, $request->validated());
        return redirect()->route('admin.payment-terms.index')
            ->with('success', 'Payment term updated successfully.');
    }

    public function destroy(PaymentTerm $paymentTerm): RedirectResponse
    {
        $this->paymentTermService->delete($paymentTerm);
        return redirect()->route('admin.payment-terms.index')
            ->with('success', 'Payment term deleted successfully.');
    }
}
