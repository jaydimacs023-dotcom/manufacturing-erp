<?php

namespace Modules\Warehouse\Services;

use App\Services\AuditService;
use App\Services\NumberSeriesService;
use Modules\Warehouse\Models\WarehouseTransfer;
use Modules\Warehouse\Repositories\WarehouseTransferRepository;
use Modules\Warehouse\Enums\WarehouseTransferStatus;

class WarehouseTransferService
{
    public function __construct(
        protected WarehouseTransferRepository $transferRepository,
        protected NumberSeriesService $numberSeriesService,
        protected AuditService $auditService,
    ) {}

    public function getPaginated(int $perPage = 15)
    {
        return $this->transferRepository->paginate($perPage);
    }

    public function create(array $data): WarehouseTransfer
    {
        if (!isset($data['transfer_number'])) {
            $data['transfer_number'] = $this->numberSeriesService->generateNext('WAREHOUSE_TRANSFER');
        }
        if (!isset($data['status'])) {
            $data['status'] = WarehouseTransferStatus::Draft->value;
        }
        if (!isset($data['transfer_date'])) {
            $data['transfer_date'] = now();
        }

        $transfer = $this->transferRepository->create($data);
        $this->auditService->logCreate('warehouse', $transfer->transfer_number, $data);
        return $transfer;
    }

    public function update(WarehouseTransfer $transfer, array $data): bool
    {
        $old = $transfer->toArray();
        $result = $this->transferRepository->update($transfer, $data);
        if ($result) {
            $this->auditService->logUpdate('warehouse', $transfer->transfer_number, $old, $data);
        }
        return $result;
    }

    public function delete(WarehouseTransfer $transfer): bool
    {
        $this->auditService->logDelete('warehouse', $transfer->transfer_number, $transfer->toArray());
        return $this->transferRepository->delete($transfer);
    }

    public function approve(WarehouseTransfer $transfer): bool
    {
        $transfer->status = WarehouseTransferStatus::Approved->value;
        $transfer->approved_by = auth()->id();
        $transfer->approved_at = now();
        $result = $transfer->save();
        if ($result) {
            $this->auditService->logApprove('warehouse', $transfer->transfer_number);
        }
        return $result;
    }

    public function complete(WarehouseTransfer $transfer): bool
    {
        $transfer->status = WarehouseTransferStatus::Completed->value;
        $result = $transfer->save();
        if ($result) {
            $this->auditService->logComplete('warehouse', $transfer->transfer_number);
        }
        return $result;
    }

    public function cancel(WarehouseTransfer $transfer): bool
    {
        $transfer->status = WarehouseTransferStatus::Cancelled->value;
        $result = $transfer->save();
        if ($result) {
            $this->auditService->logCancel('warehouse', $transfer->transfer_number);
        }
        return $result;
    }
}

