<?php

namespace Modules\Administration\Controllers;

use App\Http\Controllers\Controller;
use Modules\Administration\Models\Branch;
use Modules\Administration\Requests\StoreBranchRequest;
use Modules\Administration\Requests\UpdateBranchRequest;
use Modules\Administration\Services\BranchService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BranchController extends Controller
{
    public function __construct(
        protected BranchService $branchService,
    ) {}

    public function index(): View
    {
        $branches = $this->branchService->getPaginated();
        return view('admin.branches.index', compact('branches'));
    }

    public function create(): View
    {
        return view('admin.branches.create');
    }

    public function store(StoreBranchRequest $request): RedirectResponse
    {
        $this->branchService->create($request->validated());
        return redirect()->route('admin.branches.index')
            ->with('success', 'Branch created successfully.');
    }

    public function show(Branch $branch): View
    {
        return view('admin.branches.show', compact('branch'));
    }

    public function edit(Branch $branch): View
    {
        return view('admin.branches.edit', compact('branch'));
    }

    public function update(UpdateBranchRequest $request, Branch $branch): RedirectResponse
    {
        $this->branchService->update($branch, $request->validated());
        return redirect()->route('admin.branches.index')
            ->with('success', 'Branch updated successfully.');
    }

    public function destroy(Branch $branch): RedirectResponse
    {
        $this->branchService->delete($branch);
        return redirect()->route('admin.branches.index')
            ->with('success', 'Branch deleted successfully.');
    }
}

