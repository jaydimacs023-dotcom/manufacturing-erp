<?php

namespace Modules\Manufacturing\Services;

use App\Services\AuditService;
use App\Services\NumberSeriesService;
use Modules\Manufacturing\Enums\ManufacturingOrderStatus;
use Modules\Manufacturing\Models\ManufacturingOrder;
use Modules\Manufacturing\Repositories\ManufacturingOrderRepository;
use Modules\Manufacturing\Repositories\ManufacturingOrderItemRepository;
use Modules\Manufacturing\Repositories\BillOfMaterialRepository;
use Modules\Inventory\Services\InventoryService;
use Modules\Inventory\Repositories\StockReservationRepository;

class ManufacturingOrderService
{
    public function __construct(
        protected ManufacturingOrderRepository $moRepository,
        protected ManufacturingOrderItemRepository $moItemRepository,
        protected BillOfMaterialRepository $bomRepository,
        protected InventoryService $inventoryService,
        protected StockReservationRepository $reservationRepository,
        protected NumberSeriesService $numberSeriesService,
        protected AuditService $auditService,
    ) {}

    public function getPaginated(int $perPage = 15)
    {
        return $this->moRepository->paginate($perPage);
    }

    public function findById(int $id): ?ManufacturingOrder
    {
        return $this->moRepository->find($id);
    }

    public function create(array $data): ManufacturingOrder
    {
        if (!isset($data['mo_number'])) {
            $data['mo_number'] = $this->numberSeriesService->generateNext('MANUFACTURING_ORDER');
        }
        if (!isset($data['status'])) {
            $data['status'] = ManufacturingOrderStatus::Draft->value;
        }

        $mo = $this->moRepository->create($data);

        // Create MO items from BOM if BOM is specified
        if (isset($data['bill_of_material_id']) && $data['bill_of_material_id']) {
            $bom = $this->bomRepository->find($data['bill_of_material_id']);
            if ($bom && $bom->items) {
                $plannedQty = $data['planned_quantity'] ?? 1;
                foreach ($bom->items as $bomItem) {
                    $this->moItemRepository->create([
                        'manufacturing_order_id' => $mo->id,
                        'product_id' => $bomItem->product_id,
                        'uom_id' => $bomItem->uom_id,
                        'planned_quantity' => $bomItem->quantity * $plannedQty,
                        'issued_quantity' => 0,
                        'unit_cost' => $bomItem->unit_cost ?? 0,
                        'total_cost' => ($bomItem->unit_cost ?? 0) * ($bomItem->quantity * $plannedQty),
                    ]);
                }
            }
        }

        $this->auditService->logCreate('manufacturing', $mo->mo_number, $data);

        return $mo;
    }

    public function update(ManufacturingOrder $mo, array $data): bool
    {
        $oldValues = $mo->toArray();
        $result = $this->moRepository->update($mo, $data);

        if ($result) {
            $this->auditService->logUpdate('manufacturing', $mo->mo_number, $oldValues, $data);
        }

        return $result;
    }

    public function delete(ManufacturingOrder $mo): bool
    {
        $this->auditService->logDelete('manufacturing', $mo->mo_number, $mo->toArray());
        return $this->moRepository->delete($mo);
    }

    public function release(ManufacturingOrder $mo): bool
    {
        $mo->status = ManufacturingOrderStatus::Released->value;
        $result = $mo->save();

        if ($result) {
            // Reserve materials from inventory
            $warehouseId = $mo->warehouse_id;
            foreach ($mo->items as $item) {
                if ($item->planned_quantity > 0) {
                    $this->reservationRepository->create([
                        'product_id' => $item->product_id,
                        'warehouse_id' => $warehouseId,
                        'reference_type' => 'manufacturing_order',
                        'reference_id' => $mo->id,
                        'quantity_reserved' => $item->planned_quantity,
                        'quantity_consumed' => 0,
                        'status' => 'active',
                    ]);
                }
            }

            $this->auditService->logSubmit('manufacturing', $mo->mo_number);
        }

        return $result;
    }

    public function startProduction(ManufacturingOrder $mo): bool
    {
        $mo->status = ManufacturingOrderStatus::InProgress->value;
        $mo->actual_start_date = now();
        $result = $mo->save();

        if ($result) {
            $this->auditService->log('start', 'manufacturing', $mo->mo_number);
        }

        return $result;
    }

    public function complete(ManufacturingOrder $mo): bool
    {
        $mo->status = ManufacturingOrderStatus::QualityInspection->value;
        $result = $mo->save();

        if ($result) {
            $this->auditService->logComplete('manufacturing', $mo->mo_number);
        }

        return $result;
    }

    public function close(ManufacturingOrder $mo): bool
    {
        $mo->status = ManufacturingOrderStatus::Completed->value;
        $mo->actual_end_date = now();
        $result = $mo->save();

        if ($result) {
            $this->auditService->log('close', 'manufacturing', $mo->mo_number);
        }

        return $result;
    }

    public function cancel(ManufacturingOrder $mo): bool
    {
        $mo->status = ManufacturingOrderStatus::Cancelled->value;
        $result = $mo->save();

        if ($result) {
            $this->auditService->logCancel('manufacturing', $mo->mo_number);
        }

        return $result;
    }

    public function findPendingProduction()
    {
        return $this->moRepository->findPendingProduction();
    }

    public function findByStatus(string $status)
    {
        return $this->moRepository->findByStatus($status);
    }

    public function findTodayOrders()
    {
        return $this->moRepository->findTodayOrders();
    }

    public function getDashboardStats()
    {
        $totalOrders = $this->moRepository->count();
        $inProgress = $this->moRepository->findInProgress()->count();
        $todayOrders = $this->moRepository->findTodayOrders()->count();

        return compact('totalOrders', 'inProgress', 'todayOrders');
    }
}
