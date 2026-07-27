<?php

namespace Modules\BusinessPartner\Controllers;

use App\Http\Controllers\Controller;
use Modules\BusinessPartner\Models\BusinessPartner;
use Modules\BusinessPartner\Models\ContactPerson;
use Modules\BusinessPartner\Requests\StoreContactPersonRequest;
use Modules\BusinessPartner\Requests\UpdateContactPersonRequest;
use Modules\BusinessPartner\Services\ContactPersonService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactPersonController extends Controller
{
    public function __construct(
        protected ContactPersonService $contactPersonService,
    ) {}

    public function index(BusinessPartner $businessPartner): View
    {
        $contactPersons = $this->contactPersonService->getByPartner($businessPartner->id);
        return view('admin.contact-persons.index', compact('businessPartner', 'contactPersons'));
    }

    public function create(BusinessPartner $businessPartner): View
    {
        return view('admin.contact-persons.create', compact('businessPartner'));
    }

    public function store(StoreContactPersonRequest $request, BusinessPartner $businessPartner): RedirectResponse
    {
        $this->contactPersonService->create($businessPartner->id, $request->validated());
        return redirect()->route('admin.business-partners.contact-persons.index', $businessPartner)
            ->with('success', 'Contact person created successfully.');
    }

    public function edit(BusinessPartner $businessPartner, ContactPerson $contactPerson): View
    {
        return view('admin.contact-persons.edit', compact('businessPartner', 'contactPerson'));
    }

    public function update(UpdateContactPersonRequest $request, BusinessPartner $businessPartner, ContactPerson $contactPerson): RedirectResponse
    {
        $this->contactPersonService->update($contactPerson, $request->validated());
        return redirect()->route('admin.business-partners.contact-persons.index', $businessPartner)
            ->with('success', 'Contact person updated successfully.');
    }

    public function destroy(BusinessPartner $businessPartner, ContactPerson $contactPerson): RedirectResponse
    {
        $this->contactPersonService->delete($contactPerson);
        return redirect()->route('admin.business-partners.contact-persons.index', $businessPartner)
            ->with('success', 'Contact person deleted successfully.');
    }
}
