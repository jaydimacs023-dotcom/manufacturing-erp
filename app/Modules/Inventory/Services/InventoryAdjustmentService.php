<?php

namespace Modules\Inventory\Services;

use App\Services\AuditService;
use App\Services\NumberSeriesService;
use Modules\Inventory\Models\InventoryAdjustment;
use Modules\Inventory\Repositories\InventoryAdjustmentRepository;
use Modules\Inventory\Repositories\InventoryAdjustmentItemRepository;
use Modules\Inventory\Enums\InventoryAdjustmentStatus;
use Modules\Inventory\Services\InventoryService;

class InventoryAdjustmentService
{
    public function __construct(
        protected InventoryAdjustmentRepository $adjustmentRepository,
        protected InventoryAdjustmentItemRepository $adjustmentItemRepository,
        protected InventoryService $inventoryService,
        protected NumberSeriesService $numberSeriesService,
        protected AuditService $auditService,
    ) {}

    public function getPaginated(int $perPage = 15)
    {
        return $this->adjustmentRepository->paginate($perPage);
    }

    public function findById(int $id): ?InventoryAdjustment
    {
        return $this->adjustmentRepository->find($id);
    }

    public function create(array $data): InventoryAdjustment
    {
        if (!isset($data['adjustment_number'])) {
            $data['adjustment_number'] = $this->numberSeriesService->generateNext('INVENTORY_ADJUSTMENT');
        }
        if (!isset($data['status'])) {
            $data['status'] = InventoryAdjustmentStatus::Draft->value;
        }

        $adjustment = $this->adjustmentRepository->create($data);

        // Create adjustment items
        if (isset($data['items']) && is_array($data['items'])) {
            foreach ($data['items'] as $item) {
                $item['inventory_adjustment_id'] = $adjustment->id;
                $this->adjustmentItemRepository->create($item);
            }
        }

        $this->auditService->logCreate('inventory', $adjustment->adjustment_number, $data);

        return $adjustment;
    }

    public function update(InventoryAdjustment $adjustment, array $data): bool
    {
        $oldValues = $adjustment->toArray();
        $result = $this->adjustmentRepository->update($adjustment, $data);

        if ($result) {
            $this->auditService->logUpdate('inventory', $adjustment->adjustment_number, $oldValues, $data);
        }

        return $result;
    }

    public function delete(InventoryAdjustment $adjustment): bool
    {
        $this->auditService->logDelete('inventory', $adjustment->adjustment_number, $adjustment->toArray());
        return $this->adjustmentRepository->delete($adjustment);
    }

    public function submit(InventoryAdjustment $adjustment): bool
    {
        $adjustment->status = InventoryAdjustmentStatus::PendingApproval->value;
        $result = $adjustment->save();

        if ($result) {
            $this->auditService->logSubmit('inventory', $adjustment->adjustment_number);
        }

        return $result;
    }

    public function approve(InventoryAdjustment $adjustment, ?string $remarks = null): bool
    {
        $adjustment->status = InventoryAdjustmentStatus::Approved->value;
        $adjustment->approved_by = auth()->id();
        $adjustment->approved_at = now();
        if ($remarks) {
            $adjustment->remarks = $remarks;
        }
        $result = $adjustment->save();

        if ($result) {
            // Update stock cards based on adjustment items
            foreach ($adjustment->items as $item) {
                $movementType = $item->difference > 0 ? 'adjustment_plus' : 'adjustment_minus';
                $this->inventoryService->recordMovement([
                    'movement_type' => $movementType,
                    'product_id' => $item->product_id,
                    'warehouse_id' => $adjustment->warehouse_id,
                    'uom_id' => $item->uom_id,
                    'quantity' => abs($item->difference),
                    'unit_cost' => $item->unit_cost,
                    'batch_number' => $item->batch_number,
                    'expiry_date' => $item->expiry_date,
                    'reference_type' => 'inventory_adjustment',
                    'reference_id' => $adjustment->id,
                    'remarks' => "Adjustment: {$adjustment->adjustment_number}",
                ]);
            }

            $this->auditService->logApprove('inventory', $adjustment->adjustment_number);
        }

        return $result;
    }

    public function reject(InventoryAdjustment $adjustment, string $reason): bool
    {
        $adjustment->status = InventoryAdjustmentStatus::Rejected->value;
        $adjustment->rejected_by = auth()->id();
        $adjustment->rejected_at = now();
        $adjustment->rejection_reason = $reason;
        $result = $adjustment->save();

        if ($result) {
            $this->auditService->logReject('inventory', $adjustment->adjustment_number, $reason);
        }

        return $result;
    }

    public function cancel(InventoryAdjustment $adjustment): bool
    {
        $adjustment->status = InventoryAdjustmentStatus::Cancelled->value;
        $result = $adjustment->save();

        if ($result) {
            $this->auditService->logCancel('inventory', $adjustment->adjustment_number);
        }

        return $result;
    }

    public function findPendingApproval()
    {
        return $this->adjustmentRepository->findPendingApproval();
    }
}
