<?php

namespace Modules\QualityControl\Services;

use App\Services\AuditService;
use App\Services\NumberSeriesService;
use Modules\QualityControl\Models\NonConformance;
use Modules\QualityControl\Repositories\NonConformanceRepository;

class NonConformanceService
{
    public function __construct(
        protected NonConformanceRepository $ncRepository,
        protected NumberSeriesService $numberSeriesService,
        protected AuditService $auditService,
    ) {}

    public function getPaginated(int $perPage = 15)
    {
        return $this->ncRepository->paginate($perPage);
    }

    public function findById(int $id): ?NonConformance
    {
        return $this->ncRepository->find($id);
    }

    public function create(array $data): NonConformance
    {
        if (!isset($data['nc_number'])) {
            $data['nc_number'] = $this->numberSeriesService->generateNext('CORRECTIVE_ACTION');
        }
        if (!isset($data['status'])) {
            $data['status'] = 'open';
        }

        $nc = $this->ncRepository->create($data);
        $this->auditService->logCreate('non_conformance', $nc->nc_number, $data);

        return $nc;
    }

    public function update(NonConformance $nc, array $data): bool
    {
        $oldValues = $nc->toArray();
        $result = $this->ncRepository->update($nc, $data);

        if ($result) {
            $this->auditService->logUpdate('non_conformance', $nc->nc_number, $oldValues, $data);
        }

        return $result;
    }

    public function delete(NonConformance $nc): bool
    {
        $this->auditService->logDelete('non_conformance', $nc->nc_number, $nc->toArray());
        return $this->ncRepository->delete($nc);
    }

    public function resolve(NonConformance $nc, string $resolution, ?string $rootCause = null): bool
    {
        $nc->status = 'resolved';
        $nc->resolved_at = now();
        $nc->resolution_notes = $resolution;
        if ($rootCause) {
            $nc->root_cause = $rootCause;
        }
        $result = $nc->save();

        if ($result) {
            $this->auditService->log('resolve', 'non_conformance', $nc->nc_number);
        }

        return $result;
    }

    public function close(NonConformance $nc): bool
    {
        $nc->status = 'closed';
        $result = $nc->save();

        if ($result) {
            $this->auditService->log('close', 'non_conformance', $nc->nc_number);
        }

        return $result;
    }

    public function findOpen()
    {
        return $this->ncRepository->findOpen();
    }

    public function findByInspection(int $inspectionId)
    {
        return $this->ncRepository->findByInspection($inspectionId);
    }
}

