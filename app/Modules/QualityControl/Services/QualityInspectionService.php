<?php

namespace Modules\QualityControl\Services;

use App\Services\AuditService;
use App\Services\NumberSeriesService;
use Modules\QualityControl\Enums\QualityInspectionStatus;
use Modules\QualityControl\Enums\QualityInspectionType;
use Modules\QualityControl\Models\QualityInspection;
use Modules\QualityControl\Repositories\QualityInspectionRepository;
use Modules\QualityControl\Repositories\QualityInspectionItemRepository;
use Modules\QualityControl\Repositories\QualityChecklistRepository;
use Modules\QualityControl\Repositories\InspectionTypeRepository;

class QualityInspectionService
{
    public function __construct(
        protected QualityInspectionRepository $inspectionRepository,
        protected QualityInspectionItemRepository $itemRepository,
        protected QualityChecklistRepository $checklistRepository,
        protected InspectionTypeRepository $inspectionTypeRepository,
        protected NumberSeriesService $numberSeriesService,
        protected AuditService $auditService,
    ) {}

    public function getPaginated(int $perPage = 15)
    {
        return $this->inspectionRepository->paginate($perPage);
    }

    public function findById(int $id): ?QualityInspection
    {
        return $this->inspectionRepository->find($id);
    }

    public function create(array $data): QualityInspection
    {
        if (!isset($data['inspection_number'])) {
            $prefix = match ($data['inspection_type'] ?? 'incoming') {
                'incoming' => 'INCOMING_QC',
                'in_process' => 'PROCESS_QC',
                'final' => 'FINISHED_QC',
                default => 'INCOMING_QC',
            };
            $data['inspection_number'] = $this->numberSeriesService->generateNext($prefix);
        }
        if (!isset($data['status'])) {
            $data['status'] = QualityInspectionStatus::Draft->value;
        }

        $inspection = $this->inspectionRepository->create($data);

        // Load checklist items if checklist is specified
        if (isset($data['quality_checklist_id']) && $data['quality_checklist_id']) {
            $checklistItems = $this->checklistRepository->find($data['quality_checklist_id']);
            if ($checklistItems && $checklistItems->items) {
                foreach ($checklistItems->items as $item) {
                    $this->itemRepository->create([
                        'quality_inspection_id' => $inspection->id,
                        'checklist_item_id' => $item->id,
                        'item_name' => $item->item_name,
                        'specification' => $item->specification,
                        'method' => $item->method,
                        'expected_value' => $item->expected_value,
                        'min_value' => $item->min_value,
                        'max_value' => $item->max_value,
                        'unit' => $item->unit,
                        'sort_order' => $item->sort_order,
                    ]);
                }
            }
        }

        $this->auditService->logCreate('quality_control', $inspection->inspection_number, $data);

        return $inspection;
    }

    public function update(QualityInspection $inspection, array $data): bool
    {
        $oldValues = $inspection->toArray();
        $result = $this->inspectionRepository->update($inspection, $data);

        if ($result) {
            $this->auditService->logUpdate('quality_control', $inspection->inspection_number, $oldValues, $data);
        }

        return $result;
    }

    public function delete(QualityInspection $inspection): bool
    {
        $this->auditService->logDelete('quality_control', $inspection->inspection_number, $inspection->toArray());
        return $this->inspectionRepository->delete($inspection);
    }

    public function recordResults(QualityInspection $inspection, array $items): bool
    {
        $allPassed = true;
        foreach ($items as $itemData) {
            $item = $this->itemRepository->find($itemData['id']);
            if ($item) {
                $actualValue = $itemData['actual_value'] ?? null;
                $result = $itemData['result'] ?? 'pass';

                // Auto-determine result if min/max values defined
                if ($result === 'auto' && $actualValue !== null) {
                    $pass = true;
                    if ($item->min_value !== null && $actualValue < $item->min_value) {
                        $pass = false;
                    }
                    if ($item->max_value !== null && $actualValue > $item->max_value) {
                        $pass = false;
                    }
                    $result = $pass ? 'pass' : 'fail';
                }

                $this->itemRepository->update($item, [
                    'actual_value' => $actualValue,
                    'result' => $result,
                    'remarks' => $itemData['remarks'] ?? null,
                ]);

                if ($result === 'fail') {
                    $allPassed = false;
                }
            }
        }

        // Update inspection quantities
        $totalItems = $items ? count($items) : 0;
        $passedItems = count(array_filter($items, fn($i) => ($i['result'] ?? 'pass') === 'pass'));
        $failedItems = $totalItems - $passedItems;

        $this->inspectionRepository->update($inspection, [
            'quantity_inspected' => $totalItems,
            'quantity_passed' => $passedItems,
            'quantity_failed' => $failedItems,
        ]);

        $this->auditService->log('record_results', 'quality_control', $inspection->inspection_number, null, ['items_updated' => count($items)]);

        return $allPassed;
    }

    public function approve(QualityInspection $inspection): bool
    {
        $inspection->status = QualityInspectionStatus::Passed->value;
        $inspection->approved_by = auth()->id();
        $inspection->approved_at = now();
        $inspection->completed_at = now();
        $result = $inspection->save();

        if ($result) {
            $this->auditService->logApprove('quality_control', $inspection->inspection_number);
        }

        return $result;
    }

    public function reject(QualityInspection $inspection): bool
    {
        $inspection->status = QualityInspectionStatus::Failed->value;
        $inspection->completed_at = now();
        $result = $inspection->save();

        if ($result) {
            $this->auditService->logReject('quality_control', $inspection->inspection_number);
        }

        return $result;
    }

    public function conditionalAccept(QualityInspection $inspection): bool
    {
        $inspection->status = QualityInspectionStatus::Conditional->value;
        $inspection->completed_at = now();
        $result = $inspection->save();

        if ($result) {
            $this->auditService->log('conditional_accept', 'quality_control', $inspection->inspection_number);
        }

        return $result;
    }

    public function cancel(QualityInspection $inspection): bool
    {
        $inspection->status = QualityInspectionStatus::Cancelled->value;
        $result = $inspection->save();

        if ($result) {
            $this->auditService->logCancel('quality_control', $inspection->inspection_number);
        }

        return $result;
    }

    public function findPending()
    {
        return $this->inspectionRepository->findPending();
    }

    public function findTodayInspections()
    {
        return $this->inspectionRepository->findTodayInspections();
    }

    public function findBySource(string $sourceType, int $sourceId)
    {
        return $this->inspectionRepository->findBySource($sourceType, $sourceId);
    }

    public function getDashboardStats()
    {
        $total = $this->inspectionRepository->count();
        $pending = $this->findPending()->count();
        $today = $this->findTodayInspections()->count();
        $passed = $this->inspectionRepository->findByStatus('passed')->count();
        $failed = $this->inspectionRepository->findByStatus('failed')->count();

        return compact('total', 'pending', 'today', 'passed', 'failed');
    }
}

