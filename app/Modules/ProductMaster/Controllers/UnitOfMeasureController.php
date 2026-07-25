<?php

namespace Modules\ProductMaster\Controllers;

use App\Http\Controllers\Controller;
use Modules\ProductMaster\Models\UnitOfMeasure;
use Modules\ProductMaster\Requests\StoreUnitOfMeasureRequest;
use Modules\ProductMaster\Requests\UpdateUnitOfMeasureRequest;
use Modules\ProductMaster\Services\UnitOfMeasureService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UnitOfMeasureController extends Controller
{
    public function __construct(
        protected UnitOfMeasureService $uomService,
    ) {}

    public function index(): View
    {
        $unitsOfMeasure = $this->uomService->getPaginated();
        return view('admin.units-of-measure.index', compact('unitsOfMeasure'));
    }

    public function create(): View
    {
        return view('admin.units-of-measure.create');
    }

    public function store(StoreUnitOfMeasureRequest $request): RedirectResponse
    {
        $this->uomService->create($request->validated());
        return redirect()->route('admin.units-of-measure.index')
            ->with('success', 'Unit of measure created successfully.');
    }

    public function edit(UnitOfMeasure $unitsOfMeasure): View
    {
        return view('admin.units-of-measure.edit', compact('unitsOfMeasure'));
    }

    public function update(UpdateUnitOfMeasureRequest $request, UnitOfMeasure $unitsOfMeasure): RedirectResponse
    {
        $this->uomService->update($unitsOfMeasure, $request->validated());
        return redirect()->route('admin.units-of-measure.index')
            ->with('success', 'Unit of measure updated successfully.');
    }

    public function destroy(UnitOfMeasure $unitsOfMeasure): RedirectResponse
    {
        $this->uomService->delete($unitsOfMeasure);
        return redirect()->route('admin.units-of-measure.index')
            ->with('success', 'Unit of measure deleted successfully.');
    }
}

