<?php

namespace Modules\QualityControl\Services;

use App\Services\AuditService;
use App\Services\NumberSeriesService;
use Modules\QualityControl\Enums\CorrectiveActionStatus;
use Modules\QualityControl\Models\CorrectiveAction;
use Modules\QualityControl\Repositories\CorrectiveActionRepository;

class CorrectiveActionService
{
    public function __construct(
        protected CorrectiveActionRepository $caRepository,
        protected NumberSeriesService $numberSeriesService,
        protected AuditService $auditService,
    ) {}

    public function getPaginated(int $perPage = 15)
    {
        return $this->caRepository->paginate($perPage);
    }

    public function findById(int $id): ?CorrectiveAction
    {
        return $this->caRepository->find($id);
    }

    public function create(array $data): CorrectiveAction
    {
        if (!isset($data['action_number'])) {
            $data['action_number'] = $this->numberSeriesService->generateNext('CORRECTIVE_ACTION');
        }
        if (!isset($data['status'])) {
            $data['status'] = CorrectiveActionStatus::Open->value;
        }

        $ca = $this->caRepository->create($data);
        $this->auditService->logCreate('corrective_action', $ca->action_number, $data);

        return $ca;
    }

    public function update(CorrectiveAction $ca, array $data): bool
    {
        $oldValues = $ca->toArray();
        $result = $this->caRepository->update($ca, $data);

        if ($result) {
            $this->auditService->logUpdate('corrective_action', $ca->action_number, $oldValues, $data);
        }

        return $result;
    }

    public function delete(CorrectiveAction $ca): bool
    {
        $this->auditService->logDelete('corrective_action', $ca->action_number, $ca->toArray());
        return $this->caRepository->delete($ca);
    }

    public function start(CorrectiveAction $ca): bool
    {
        $ca->status = CorrectiveActionStatus::InProgress->value;
        $result = $ca->save();

        if ($result) {
            $this->auditService->log('start', 'corrective_action', $ca->action_number);
        }

        return $result;
    }

    public function complete(CorrectiveAction $ca, string $actionTaken, bool $isEffective = true): bool
    {
        $ca->status = CorrectiveActionStatus::Completed->value;
        $ca->action_taken = $actionTaken;
        $ca->is_effective = $isEffective;
        $ca->completed_at = now();
        $result = $ca->save();

        if ($result) {
            $this->auditService->logComplete('corrective_action', $ca->action_number);
        }

        return $result;
    }

    public function approve(CorrectiveAction $ca): bool
    {
        $ca->status = CorrectiveActionStatus::Closed->value;
        $ca->approved_by = auth()->id();
        $ca->approved_at = now();
        $result = $ca->save();

        if ($result) {
            $this->auditService->logApprove('corrective_action', $ca->action_number);
        }

        return $result;
    }

    public function findOpen()
    {
        return $this->caRepository->findOpen();
    }

    public function findOverdue()
    {
        return $this->caRepository->findOverdue();
    }

    public function findByInspection(int $inspectionId)
    {
        return $this->caRepository->findByInspection($inspectionId);
    }
}

