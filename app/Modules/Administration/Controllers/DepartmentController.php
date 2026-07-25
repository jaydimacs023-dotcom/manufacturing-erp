<?php

namespace Modules\Administration\Controllers;

use App\Http\Controllers\Controller;
use Modules\Administration\Models\Department;
use Modules\Administration\Requests\StoreDepartmentRequest;
use Modules\Administration\Requests\UpdateDepartmentRequest;
use Modules\Administration\Services\DepartmentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    public function __construct(
        protected DepartmentService $departmentService,
    ) {}

    public function index(): View
    {
        $departments = $this->departmentService->getPaginated();
        return view('admin.departments.index', compact('departments'));
    }

    public function create(): View
    {
        return view('admin.departments.create');
    }

    public function store(StoreDepartmentRequest $request): RedirectResponse
    {
        $this->departmentService->create($request->validated());
        return redirect()->route('admin.departments.index')
            ->with('success', 'Department created successfully.');
    }

    public function show(Department $department): View
    {
        return view('admin.departments.show', compact('department'));
    }

    public function edit(Department $department): View
    {
        return view('admin.departments.edit', compact('department'));
    }

    public function update(UpdateDepartmentRequest $request, Department $department): RedirectResponse
    {
        $this->departmentService->update($department, $request->validated());
        return redirect()->route('admin.departments.index')
            ->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department): RedirectResponse
    {
        $this->departmentService->delete($department);
        return redirect()->route('admin.departments.index')
            ->with('success', 'Department deleted successfully.');
    }
}

