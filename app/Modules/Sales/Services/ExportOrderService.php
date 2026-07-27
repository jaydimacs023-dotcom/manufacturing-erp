<?php

namespace Modules\Sales\Services;

use App\Services\AuditService;
use App\Services\NumberSeriesService;
use Modules\Sales\Models\ExportOrder;
use Modules\Sales\Repositories\ExportOrderRepository;
use Modules\Sales\Repositories\ExportOrderItemRepository;
use Modules\Sales\Enums\ExportOrderStatus;

class ExportOrderService
{
    public function __construct(
        protected ExportOrderRepository $exportOrderRepository,
        protected ExportOrderItemRepository $exportOrderItemRepository,
        protected NumberSeriesService $numberSeriesService,
        protected AuditService $auditService,
    ) {}

    public function getPaginated(int $perPage = 15)
    {
        return $this->exportOrderRepository->paginate($perPage);
    }

    public function create(array $data): ExportOrder
    {
        if (!isset($data['export_order_number'])) {
            $data['export_order_number'] = $this->numberSeriesService->generateNext('ExportOrder');
        }
        if (!isset($data['status'])) {
            $data['status'] = ExportOrderStatus::Draft->value;
        }

        $items = $data['items'] ?? [];
        unset($data['items']);

        $exportOrder = $this->exportOrderRepository->create($data);

        if (!empty($items)) {
            foreach ($items as $item) {
                $item['export_order_id'] = $exportOrder->id;
                $this->exportOrderItemRepository->create($item);
            }
        }

        $this->auditService->logCreate('sales', $exportOrder->export_order_number, $data);
        return $exportOrder;
    }

    public function update(ExportOrder $exportOrder, array $data): bool
    {
        $old = $exportOrder->toArray();
        $items = $data['items'] ?? null;
        unset($data['items']);

        $result = $this->exportOrderRepository->update($exportOrder, $data);

        if ($items !== null && $result) {
            $exportOrder->items()->delete();
            foreach ($items as $item) {
                $item['export_order_id'] = $exportOrder->id;
                $this->exportOrderItemRepository->create($item);
            }
        }

        if ($result) {
            $this->auditService->logUpdate('sales', $exportOrder->export_order_number, $old, $data);
        }
        return $result;
    }

    public function delete(ExportOrder $exportOrder): bool
    {
        $this->auditService->logDelete('sales', $exportOrder->export_order_number, $exportOrder->toArray());
        return $this->exportOrderRepository->delete($exportOrder);
    }

    public function approve(ExportOrder $exportOrder): bool
    {
        $exportOrder->status = ExportOrderStatus::Planned->value;
        $exportOrder->approved_by = auth()->id();
        $exportOrder->approved_at = now();
        $result = $exportOrder->save();
        if ($result) {
            $this->auditService->logApprove('sales', $exportOrder->export_order_number);
        }
        return $result;
    }

    public function markLoaded(ExportOrder $exportOrder): bool
    {
        $exportOrder->status = ExportOrderStatus::Loaded->value;
        return $exportOrder->save();
    }

    public function dispatch(ExportOrder $exportOrder): bool
    {
        $exportOrder->status = ExportOrderStatus::Dispatched->value;
        $exportOrder->shipped_at = now();
        return $exportOrder->save();
    }

    public function markInTransit(ExportOrder $exportOrder): bool
    {
        $exportOrder->status = ExportOrderStatus::InTransit->value;
        return $exportOrder->save();
    }

    public function markDelivered(ExportOrder $exportOrder): bool
    {
        $exportOrder->status = ExportOrderStatus::Delivered->value;
        $exportOrder->delivered_at = now();
        $result = $exportOrder->save();
        if ($result) {
            $this->auditService->log('delivered', 'sales', $exportOrder->export_order_number);
        }
        return $result;
    }

    public function cancel(ExportOrder $exportOrder): bool
    {
        $exportOrder->status = ExportOrderStatus::Cancelled->value;
        $result = $exportOrder->save();
        if ($result) {
            $this->auditService->logCancel('sales', $exportOrder->export_order_number);
        }
        return $result;
    }
}

