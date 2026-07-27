<?php

namespace Modules\QualityControl\Controllers;

use App\Http\Controllers\Controller;
use Modules\QualityControl\Models\CorrectiveAction;
use Modules\QualityControl\Requests\StoreCorrectiveActionRequest;
use Modules\QualityControl\Services\CorrectiveActionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CorrectiveActionController extends Controller
{
    public function __construct(
        protected CorrectiveActionService $caService,
    ) {}

    public function index(): View
    {
        $actions = $this->caService->getPaginated();
        return view('admin.quality-control.corrective-actions.index', compact('actions'));
    }

    public function create(): View
    {
        $actionTypes = [
            'rework' => 'Rework',
            're_inspection' => 'Re-inspection',
            'disposal' => 'Disposal',
            'supplier_return' => 'Supplier Return',
        ];
        return view('admin.quality-control.corrective-actions.create', compact('actionTypes'));
    }

    public function store(StoreCorrectiveActionRequest $request): RedirectResponse
    {
        $this->caService->create($request->validated());
        return redirect()->route('admin.quality-control.corrective-actions.index')
            ->with('success', 'Corrective Action created successfully.');
    }

    public function show(CorrectiveAction $correctiveAction): View
    {
        $correctiveAction->load(['inspection.product', 'nonConformance', 'responsiblePerson', 'approver']);
        return view('admin.quality-control.corrective-actions.show', compact('correctiveAction'));
    }

    public function update(StoreCorrectiveActionRequest $request, CorrectiveAction $correctiveAction): RedirectResponse
    {
        $this->caService->update($correctiveAction, $request->validated());
        return redirect()->route('admin.quality-control.corrective-actions.index')
            ->with('success', 'Corrective Action updated successfully.');
    }

    public function destroy(CorrectiveAction $correctiveAction): RedirectResponse
    {
        $this->caService->delete($correctiveAction);
        return redirect()->route('admin.quality-control.corrective-actions.index')
            ->with('success', 'Corrective Action deleted successfully.');
    }

    public function start(CorrectiveAction $correctiveAction): RedirectResponse
    {
        $this->caService->start($correctiveAction);
        return redirect()->route('admin.quality-control.corrective-actions.index')
            ->with('success', 'Corrective Action started.');
    }

    public function complete(StoreCorrectiveActionRequest $request, CorrectiveAction $correctiveAction): RedirectResponse
    {
        $this->caService->complete(
            $correctiveAction,
            $request->input('action_taken'),
            $request->boolean('is_effective', true)
        );
        return redirect()->route('admin.quality-control.corrective-actions.index')
            ->with('success', 'Corrective Action completed.');
    }

    public function approve(CorrectiveAction $correctiveAction): RedirectResponse
    {
        $this->caService->approve($correctiveAction);
        return redirect()->route('admin.quality-control.corrective-actions.index')
            ->with('success', 'Corrective Action approved and closed.');
    }
}

