<?php

namespace Modules\QualityControl\Controllers;

use App\Http\Controllers\Controller;
use Modules\QualityControl\Models\QualityInspection;
use Modules\QualityControl\Requests\StoreQualityInspectionRequest;
use Modules\QualityControl\Requests\UpdateQualityInspectionRequest;
use Modules\QualityControl\Services\QualityInspectionService;
use Modules\QualityControl\Services\NonConformanceService;
use Modules\QualityControl\Services\CorrectiveActionService;
use Modules\ProductMaster\Services\ProductService;
use Modules\QualityControl\Repositories\InspectionTypeRepository;
use Modules\QualityControl\Repositories\QualityChecklistRepository;
use Modules\QualityControl\Repositories\DefectTypeRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class QualityInspectionController extends Controller
{
    public function __construct(
        protected QualityInspectionService $inspectionService,
        protected NonConformanceService $ncService,
        protected CorrectiveActionService $caService,
        protected ProductService $productService,
        protected InspectionTypeRepository $inspectionTypeRepo,
        protected QualityChecklistRepository $checklistRepo,
        protected DefectTypeRepository $defectTypeRepo,
    ) {}

    public function index(): View
    {
        $inspections = $this->inspectionService->getPaginated();
        return view('admin.quality-control.inspection.index', compact('inspections'));
    }

    public function create(): View
    {
        $products = $this->productService->getAll();
        $inspectionTypes = [
            'incoming' => 'Incoming Quality Inspection',
            'in_process' => 'In-Process Quality Inspection',
            'final' => 'Finished Goods Inspection',
        ];
        $typeOptions = $this->inspectionTypeRepo->findActive();
        $checklists = $this->checklistRepo->findActive();
        return view('admin.quality-control.inspection.create', compact('products', 'inspectionTypes', 'typeOptions', 'checklists'));
    }

    public function store(StoreQualityInspectionRequest $request): RedirectResponse
    {
        $this->inspectionService->create($request->validated());
        return redirect()->route('admin.quality-control.inspections.index')
            ->with('success', 'Quality Inspection created successfully.');
    }

    public function show(QualityInspection $qualityInspection): View
    {
        $qualityInspection->load([
            'product', 'inspectionType', 'checklist', 'inspector', 'approver',
            'items', 'nonConformances.defectType', 'correctiveActions'
        ]);
        $defectTypes = $this->defectTypeRepo->findActive();
        return view('admin.quality-control.inspection.show', compact('qualityInspection', 'defectTypes'));
    }

    public function edit(QualityInspection $qualityInspection): View
    {
        $products = $this->productService->getAll();
        $inspectionTypes = [
            'incoming' => 'Incoming Quality Inspection',
            'in_process' => 'In-Process Quality Inspection',
            'final' => 'Finished Goods Inspection',
        ];
        $typeOptions = $this->inspectionTypeRepo->findActive();
        $checklists = $this->checklistRepo->findActive();
        return view('admin.quality-control.inspection.edit', compact('qualityInspection', 'products', 'inspectionTypes', 'typeOptions', 'checklists'));
    }

    public function update(UpdateQualityInspectionRequest $request, QualityInspection $qualityInspection): RedirectResponse
    {
        $this->inspectionService->update($qualityInspection, $request->validated());
        return redirect()->route('admin.quality-control.inspections.index')
            ->with('success', 'Quality Inspection updated successfully.');
    }

    public function destroy(QualityInspection $qualityInspection): RedirectResponse
    {
        $this->inspectionService->delete($qualityInspection);
        return redirect()->route('admin.quality-control.inspections.index')
            ->with('success', 'Quality Inspection deleted successfully.');
    }

    public function recordResults(UpdateQualityInspectionRequest $request, QualityInspection $qualityInspection): RedirectResponse
    {
        $items = $request->input('items', []);
        $this->inspectionService->recordResults($qualityInspection, $items);
        return redirect()->route('admin.quality-control.inspections.show', $qualityInspection)
            ->with('success', 'Inspection results recorded successfully.');
    }

    public function approve(QualityInspection $qualityInspection): RedirectResponse
    {
        $this->inspectionService->approve($qualityInspection);
        return redirect()->route('admin.quality-control.inspections.index')
            ->with('success', 'Inspection approved successfully.');
    }

    public function reject(QualityInspection $qualityInspection): RedirectResponse
    {
        $this->inspectionService->reject($qualityInspection);
        return redirect()->route('admin.quality-control.inspections.index')
            ->with('success', 'Inspection rejected.');
    }

    public function conditionalAccept(QualityInspection $qualityInspection): RedirectResponse
    {
        $this->inspectionService->conditionalAccept($qualityInspection);
        return redirect()->route('admin.quality-control.inspections.index')
            ->with('success', 'Inspection conditionally accepted.');
    }

    public function cancel(QualityInspection $qualityInspection): RedirectResponse
    {
        $this->inspectionService->cancel($qualityInspection);
        return redirect()->route('admin.quality-control.inspections.index')
            ->with('success', 'Inspection cancelled.');
    }
}

