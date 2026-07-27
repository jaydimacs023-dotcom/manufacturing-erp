<?php

namespace Modules\Inventory\Services;

use App\Services\AuditService;
use App\Services\NumberSeriesService;
use Modules\Inventory\Models\InventoryTransfer;
use Modules\Inventory\Repositories\InventoryTransferRepository;
use Modules\Inventory\Repositories\InventoryTransferItemRepository;
use Modules\Inventory\Enums\InventoryTransferStatus;

class InventoryTransferService
{
    public function __construct(
        protected InventoryTransferRepository $transferRepository,
        protected InventoryTransferItemRepository $transferItemRepository,
        protected InventoryService $inventoryService,
        protected NumberSeriesService $numberSeriesService,
        protected AuditService $auditService,
    ) {}

    public function getPaginated(int $perPage = 15)
    {
        return $this->transferRepository->paginate($perPage);
    }

    public function findById(int $id): ?InventoryTransfer
    {
        return $this->transferRepository->find($id);
    }

    public function create(array $data): InventoryTransfer
    {
        if (!isset($data['transfer_number'])) {
            $data['transfer_number'] = $this->numberSeriesService->generateNext('STOCK_TRANSFER');
        }
        if (!isset($data['status'])) {
            $data['status'] = InventoryTransferStatus::Draft->value;
        }

        $transfer = $this->transferRepository->create($data);

        // Create transfer items
        if (isset($data['items']) && is_array($data['items'])) {
            foreach ($data['items'] as $item) {
                $item['inventory_transfer_id'] = $transfer->id;
                $this->transferItemRepository->create($item);
            }
        }

        $this->auditService->logCreate('inventory', $transfer->transfer_number, $data);

        return $transfer;
    }

    public function update(InventoryTransfer $transfer, array $data): bool
    {
        $oldValues = $transfer->toArray();
        $result = $this->transferRepository->update($transfer, $data);

        if ($result) {
            $this->auditService->logUpdate('inventory', $transfer->transfer_number, $oldValues, $data);
        }

        return $result;
    }

    public function delete(InventoryTransfer $transfer): bool
    {
        $this->auditService->logDelete('inventory', $transfer->transfer_number, $transfer->toArray());
        return $this->transferRepository->delete($transfer);
    }

    public function complete(InventoryTransfer $transfer): bool
    {
        $transfer->status = InventoryTransferStatus::Completed->value;
        $result = $transfer->save();

        if ($result) {
            // Record movements for each item
            foreach ($transfer->items as $item) {
                // Decrease from source warehouse
                $this->inventoryService->recordMovement([
                    'movement_type' => 'transfer_out',
                    'product_id' => $item->product_id,
                    'warehouse_id' => $transfer->from_warehouse_id,
                    'uom_id' => $item->uom_id,
                    'quantity' => $item->quantity,
                    'unit_cost' => $item->unit_cost,
                    'batch_number' => $item->batch_number,
                    'expiry_date' => $item->expiry_date,
                    'reference_type' => 'inventory_transfer',
                    'reference_id' => $transfer->id,
                    'remarks' => "Transfer out: {$transfer->transfer_number}",
                ]);

                // Increase in destination warehouse
                $this->inventoryService->recordMovement([
                    'movement_type' => 'transfer_in',
                    'product_id' => $item->product_id,
                    'warehouse_id' => $transfer->to_warehouse_id,
                    'uom_id' => $item->uom_id,
                    'quantity' => $item->quantity,
                    'unit_cost' => $item->unit_cost,
                    'batch_number' => $item->batch_number,
                    'expiry_date' => $item->expiry_date,
                    'reference_type' => 'inventory_transfer',
                    'reference_id' => $transfer->id,
                    'remarks' => "Transfer in: {$transfer->transfer_number}",
                ]);
            }

            $this->auditService->logComplete('inventory', $transfer->transfer_number);
        }

        return $result;
    }

    public function cancel(InventoryTransfer $transfer): bool
    {
        $transfer->status = InventoryTransferStatus::Cancelled->value;
        $result = $transfer->save();

        if ($result) {
            $this->auditService->logCancel('inventory', $transfer->transfer_number);
        }

        return $result;
    }
}
