<?php

namespace Modules\Warehouse\Services;

use App\Services\AuditService;
use App\Services\NumberSeriesService;
use Modules\Warehouse\Models\Putaway;
use Modules\Warehouse\Repositories\PutawayRepository;

class PutawayService
{
    public function __construct(
        protected PutawayRepository $putawayRepository,
        protected NumberSeriesService $numberSeriesService,
        protected AuditService $auditService,
    ) {}

    public function getPaginated(int $perPage = 15)
    {
        return $this->putawayRepository->paginate($perPage);
    }

    public function create(array $data): Putaway
    {
        if (!isset($data['putaway_number'])) {
            $data['putaway_number'] = $this->numberSeriesService->generateNext('PUTAWAY');
        }
        if (!isset($data['status'])) {
            $data['status'] = 'pending';
        }

        $putaway = $this->putawayRepository->create($data);
        $this->auditService->logCreate('warehouse', $putaway->putaway_number, $data);
        return $putaway;
    }

    public function update(Putaway $putaway, array $data): bool
    {
        $old = $putaway->toArray();
        $result = $this->putawayRepository->update($putaway, $data);
        if ($result) {
            $this->auditService->logUpdate('warehouse', $putaway->putaway_number, $old, $data);
        }
        return $result;
    }

    public function delete(Putaway $putaway): bool
    {
        $this->auditService->logDelete('warehouse', $putaway->putaway_number, $putaway->toArray());
        return $this->putawayRepository->delete($putaway);
    }

    public function complete(Putaway $putaway): bool
    {
        $putaway->status = 'completed';
        $result = $putaway->save();
        if ($result) {
            $this->auditService->logComplete('warehouse', $putaway->putaway_number);
        }
        return $result;
    }

    public function cancel(Putaway $putaway): bool
    {
        $putaway->status = 'cancelled';
        $result = $putaway->save();
        if ($result) {
            $this->auditService->logCancel('warehouse', $putaway->putaway_number);
        }
        return $result;
    }
}

