<?php

namespace Modules\Sales\Services;

use App\Services\AuditService;
use App\Services\NumberSeriesService;
use Modules\Sales\Models\SalesOrder;
use Modules\Sales\Repositories\SalesOrderRepository;
use Modules\Sales\Repositories\SalesOrderItemRepository;
use Modules\Sales\Enums\SalesOrderStatus;

class SalesOrderService
{
    public function __construct(
        protected SalesOrderRepository $salesOrderRepository,
        protected SalesOrderItemRepository $salesOrderItemRepository,
        protected NumberSeriesService $numberSeriesService,
        protected AuditService $auditService,
    ) {}

    public function getPaginated(int $perPage = 15)
    {
        return $this->salesOrderRepository->paginate($perPage);
    }

    public function create(array $data): SalesOrder
    {
        if (!isset($data['sales_order_number'])) {
            $data['sales_order_number'] = $this->numberSeriesService->generateNext('SalesOrder');
        }
        if (!isset($data['status'])) {
            $data['status'] = SalesOrderStatus::Draft->value;
        }
        if (!isset($data['order_date'])) {
            $data['order_date'] = now();
        }
        if (!isset($data['currency'])) {
            $data['currency'] = 'IDR';
        }

        $items = $data['items'] ?? [];
        unset($data['items']);

        $totalAmount = 0;
        foreach ($items as &$item) {
            $item['subtotal'] = ($item['quantity'] ?? 0) * ($item['unit_price'] ?? 0);
            $totalAmount += $item['subtotal'];
        }
        $data['total_amount'] = $totalAmount;

        $salesOrder = $this->salesOrderRepository->create($data);

        if (!empty($items)) {
            foreach ($items as $item) {
                $item['sales_order_id'] = $salesOrder->id;
                $this->salesOrderItemRepository->create($item);
            }
        }

        $this->auditService->logCreate('sales', $salesOrder->sales_order_number, $data);
        return $salesOrder;
    }

    public function update(SalesOrder $salesOrder, array $data): bool
    {
        $old = $salesOrder->toArray();
        $items = $data['items'] ?? null;
        unset($data['items']);

        if ($items !== null) {
            $totalAmount = 0;
            foreach ($items as &$item) {
                $item['subtotal'] = ($item['quantity'] ?? 0) * ($item['unit_price'] ?? 0);
                $totalAmount += $item['subtotal'];
            }
            $data['total_amount'] = $totalAmount;
        }

        $result = $this->salesOrderRepository->update($salesOrder, $data);

        if ($items !== null && $result) {
            $salesOrder->items()->delete();
            foreach ($items as $item) {
                $item['sales_order_id'] = $salesOrder->id;
                $this->salesOrderItemRepository->create($item);
            }
        }

        if ($result) {
            $this->auditService->logUpdate('sales', $salesOrder->sales_order_number, $old, $data);
        }
        return $result;
    }

    public function delete(SalesOrder $salesOrder): bool
    {
        $this->auditService->logDelete('sales', $salesOrder->sales_order_number, $salesOrder->toArray());
        return $this->salesOrderRepository->delete($salesOrder);
    }

    public function submit(SalesOrder $salesOrder): bool
    {
        $salesOrder->status = SalesOrderStatus::Confirmed->value;
        return $salesOrder->save();
    }

    public function approve(SalesOrder $salesOrder): bool
    {
        $salesOrder->status = SalesOrderStatus::Allocated->value;
        $salesOrder->approved_by = auth()->id();
        $salesOrder->approved_at = now();
        $result = $salesOrder->save();
        if ($result) {
            $this->auditService->logApprove('sales', $salesOrder->sales_order_number);
        }
        return $result;
    }

    public function markReadyForShipment(SalesOrder $salesOrder): bool
    {
        $salesOrder->status = SalesOrderStatus::ReadyForShipment->value;
        return $salesOrder->save();
    }

    public function markShipped(SalesOrder $salesOrder): bool
    {
        $salesOrder->status = SalesOrderStatus::Shipped->value;
        return $salesOrder->save();
    }

    public function close(SalesOrder $salesOrder): bool
    {
        $salesOrder->status = SalesOrderStatus::Closed->value;
        $result = $salesOrder->save();
        if ($result) {
            $this->auditService->log('close', 'sales', $salesOrder->sales_order_number);
        }
        return $result;
    }

    public function cancel(SalesOrder $salesOrder): bool
    {
        $salesOrder->status = SalesOrderStatus::Cancelled->value;
        $result = $salesOrder->save();
        if ($result) {
            $this->auditService->logCancel('sales', $salesOrder->sales_order_number);
        }
        return $result;
    }
}

