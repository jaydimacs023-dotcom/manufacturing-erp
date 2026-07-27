<?php

namespace Modules\Warehouse\Services;

use App\Services\AuditService;
use App\Services\NumberSeriesService;
use Modules\Warehouse\Models\Picking;
use Modules\Warehouse\Repositories\PickingRepository;
use Modules\Warehouse\Repositories\PickingItemRepository;
use Modules\Warehouse\Repositories\StorageLocationRepository;
use Modules\Inventory\Services\InventoryService;

class PickingService
{
    public function __construct(
        protected PickingRepository $pickingRepository,
        protected PickingItemRepository $pickingItemRepository,
        protected StorageLocationRepository $storageLocationRepository,
        protected InventoryService $inventoryService,
        protected NumberSeriesService $numberSeriesService,
        protected AuditService $auditService,
    ) {}

    public function getPaginated(int $perPage = 15)
    {
        return $this->pickingRepository->paginate($perPage);
    }

    public function create(array $data): Picking
    {
        if (!isset($data['picking_number'])) {
            $data['picking_number'] = $this->numberSeriesService->generateNext('PICKING');
        }
        if (!isset($data['status'])) {
            $data['status'] = 'pending';
        }

        $picking = $this->pickingRepository->create($data);

        // Create picking items if provided
        if (isset($data['items']) && is_array($data['items'])) {
            foreach ($data['items'] as $item) {
                $item['picking_id'] = $picking->id;
                $this->pickingItemRepository->create($item);
            }
        }

        $this->auditService->logCreate('warehouse', $picking->picking_number, $data);
        return $picking;
    }

    public function delete(Picking $picking): bool
    {
        $this->auditService->logDelete('warehouse', $picking->picking_number, $picking->toArray());
        return $this->pickingRepository->delete($picking);
    }

    public function assign(Picking $picking, int $userId): bool
    {
        $picking->assigned_to = $userId;
        return $picking->save();
    }

    public function start(Picking $picking): bool
    {
        $picking->status = 'in_progress';
        return $picking->save();
    }

    public function complete(Picking $picking): bool
    {
        $picking->status = 'completed';
        $picking->completed_at = now();
        $result = $picking->save();
        if ($result) {
            $this->auditService->logComplete('warehouse', $picking->picking_number);
        }
        return $result;
    }

    public function cancel(Picking $picking): bool
    {
        $picking->status = 'cancelled';
        $result = $picking->save();
        if ($result) {
            $this->auditService->logCancel('warehouse', $picking->picking_number);
        }
        return $result;
    }
}

