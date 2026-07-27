<?php

namespace Modules\Warehouse\Services;

use App\Services\AuditService;
use App\Services\NumberSeriesService;
use Modules\Warehouse\Models\Dispatch;
use Modules\Warehouse\Repositories\DispatchRepository;
use Modules\Warehouse\Enums\DispatchStatus;

class DispatchService
{
    public function __construct(
        protected DispatchRepository $dispatchRepository,
        protected NumberSeriesService $numberSeriesService,
        protected AuditService $auditService,
    ) {}

    public function getPaginated(int $perPage = 15)
    {
        return $this->dispatchRepository->paginate($perPage);
    }

    public function create(array $data): Dispatch
    {
        if (!isset($data['dispatch_number'])) {
            $data['dispatch_number'] = $this->numberSeriesService->generateNext('DISPATCH');
        }
        if (!isset($data['status'])) {
            $data['status'] = DispatchStatus::Draft->value;
        }

        $dispatch = $this->dispatchRepository->create($data);
        $this->auditService->logCreate('warehouse', $dispatch->dispatch_number, $data);
        return $dispatch;
    }

    public function update(Dispatch $dispatch, array $data): bool
    {
        $old = $dispatch->toArray();
        $result = $this->dispatchRepository->update($dispatch, $data);
        if ($result) {
            $this->auditService->logUpdate('warehouse', $dispatch->dispatch_number, $old, $data);
        }
        return $result;
    }

    public function delete(Dispatch $dispatch): bool
    {
        $this->auditService->logDelete('warehouse', $dispatch->dispatch_number, $dispatch->toArray());
        return $this->dispatchRepository->delete($dispatch);
    }

    public function pack(Dispatch $dispatch): bool
    {
        $dispatch->status = DispatchStatus::Packed->value;
        return $dispatch->save();
    }

    public function load(Dispatch $dispatch): bool
    {
        $dispatch->status = DispatchStatus::Loaded->value;
        $dispatch->loaded_at = now();
        return $dispatch->save();
    }

    public function dispatch(Dispatch $dispatch): bool
    {
        $dispatch->status = DispatchStatus::Dispatched->value;
        $dispatch->dispatched_at = now();
        $dispatch->confirmed_by = auth()->id();
        $result = $dispatch->save();
        if ($result) {
            $this->auditService->log('dispatch', 'warehouse', $dispatch->dispatch_number);
        }
        return $result;
    }

    public function cancel(Dispatch $dispatch): bool
    {
        $dispatch->status = DispatchStatus::Cancelled->value;
        $result = $dispatch->save();
        if ($result) {
            $this->auditService->logCancel('warehouse', $dispatch->dispatch_number);
        }
        return $result;
    }

    public function approve(Dispatch $dispatch): bool
    {
        $dispatch->approved_by = auth()->id();
        $dispatch->approved_at = now();
        $result = $dispatch->save();
        if ($result) {
            $this->auditService->logApprove('warehouse', $dispatch->dispatch_number);
        }
        return $result;
    }
}

