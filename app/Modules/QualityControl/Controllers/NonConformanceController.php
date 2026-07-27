<?php

namespace Modules\QualityControl\Controllers;

use App\Http\Controllers\Controller;
use Modules\QualityControl\Models\NonConformance;
use Modules\QualityControl\Requests\StoreNonConformanceRequest;
use Modules\QualityControl\Services\NonConformanceService;
use Modules\QualityControl\Repositories\DefectTypeRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NonConformanceController extends Controller
{
    public function __construct(
        protected NonConformanceService $ncService,
        protected DefectTypeRepository $defectTypeRepo,
    ) {}

    public function index(): View
    {
        $nonConformances = $this->ncService->getPaginated();
        return view('admin.quality-control.non-conformances.index', compact('nonConformances'));
    }

    public function create(): View
    {
        $defectTypes = $this->defectTypeRepo->findActive();
        $severities = [
            'minor' => 'Minor',
            'major' => 'Major',
            'critical' => 'Critical',
        ];
        return view('admin.quality-control.non-conformances.create', compact('defectTypes', 'severities'));
    }

    public function store(StoreNonConformanceRequest $request): RedirectResponse
    {
        $this->ncService->create($request->validated());
        return redirect()->route('admin.quality-control.non-conformances.index')
            ->with('success', 'Non-conformance recorded successfully.');
    }

    public function show(NonConformance $nonConformance): View
    {
        $nonConformance->load(['inspection.product', 'defectType', 'assignedTo', 'correctiveActions']);
        return view('admin.quality-control.non-conformances.show', compact('nonConformance'));
    }

    public function update(StoreNonConformanceRequest $request, NonConformance $nonConformance): RedirectResponse
    {
        $this->ncService->update($nonConformance, $request->validated());
        return redirect()->route('admin.quality-control.non-conformances.index')
            ->with('success', 'Non-conformance updated successfully.');
    }

    public function destroy(NonConformance $nonConformance): RedirectResponse
    {
        $this->ncService->delete($nonConformance);
        return redirect()->route('admin.quality-control.non-conformances.index')
            ->with('success', 'Non-conformance deleted successfully.');
    }

    public function resolve(StoreNonConformanceRequest $request, NonConformance $nonConformance): RedirectResponse
    {
        $this->ncService->resolve(
            $nonConformance,
            $request->input('resolution_notes'),
            $request->input('root_cause')
        );
        return redirect()->route('admin.quality-control.non-conformances.index')
            ->with('success', 'Non-conformance resolved.');
    }

    public function close(NonConformance $nonConformance): RedirectResponse
    {
        $this->ncService->close($nonConformance);
        return redirect()->route('admin.quality-control.non-conformances.index')
            ->with('success', 'Non-conformance closed.');
    }
}

