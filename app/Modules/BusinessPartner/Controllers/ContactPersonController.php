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
