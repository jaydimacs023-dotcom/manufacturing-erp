<?php

namespace Modules\Administration\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Administration\Requests\StoreCompanyRequest;
use Modules\Administration\Services\CompanyService;

class CompanyController extends Controller
{
    public function __construct(
        protected CompanyService $companyService,
    ) {}

    public function index(): View
    {
        $company = $this->companyService->getActive();
        return view('admin.company.index', compact('company'));
    }

    public function create(): View
    {
        return view('admin.company.create');
    }

    public function store(StoreCompanyRequest $request): RedirectResponse
    {
        $this->companyService->create($request->validated());
        return redirect()->route('admin.company.index')
            ->with('success', 'Company created successfully.');
    }

    public function edit(int $id): View
    {
        $company = $this->companyService->findById($id);
        abort_if(!$company, 404);
        return view('admin.company.edit', compact('company'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $company = $this->companyService->findById($id);
        abort_if(!$company, 404);

        $this->companyService->update($company, $request->validate([
            'company_name' => 'required|string|max:255',
            'logo_path' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:1000',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:50',
            'tin' => 'nullable|string|max:50',
            'registration_number' => 'nullable|string|max:50',
            'default_currency' => 'nullable|string|size:3',
            'timezone' => 'nullable|string|max:100',
        ]));

        return redirect()->route('admin.company.index')
            ->with('success', 'Company updated successfully.');
    }
}

