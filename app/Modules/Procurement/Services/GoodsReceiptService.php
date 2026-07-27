<?php

namespace Modules\Procurement\Services;

use App\Services\AuditService;
use App\Services\NumberSeriesService;
use Modules\Procurement\Models\GoodsReceipt;
use Modules\Procurement\Repositories\GoodsReceiptRepository;
use Modules\Procurement\Repositories\GoodsReceiptItemRepository;

class GoodsReceiptService
{
    public function __construct(
        protected GoodsReceiptRepository $goodsReceiptRepository,
        protected GoodsReceiptItemRepository $goodsReceiptItemRepository,
        protected NumberSeriesService $numberSeriesService,
        protected AuditService $auditService,
    ) {}

    public function getPaginated(int $perPage = 15)
    {
        return $this->goodsReceiptRepository->paginate($perPage);
    }

    public function findById(int $id): ?GoodsReceipt
    {
        return $this->goodsReceiptRepository->find($id);
    }

    public function create(array $data): GoodsReceipt
    {
        if (!isset($data['goods_receipt_number'])) {
            $data['goods_receipt_number'] = $this->numberSeriesService->generateNext('GR');
        }
        if (!isset($data['status'])) {
            $data['status'] = 'draft';
        }

        $goodsReceipt = $this->goodsReceiptRepository->create($data);

        $this->auditService->logCreate('procurement', $goodsReceipt->goods_receipt_number, $data);

        return $goodsReceipt;
    }

    public function update(GoodsReceipt $goodsReceipt, array $data): bool
    {
        $oldValues = $goodsReceipt->toArray();
        $result = $this->goodsReceiptRepository->update($goodsReceipt, $data);

        if ($result) {
            $this->auditService->logUpdate('procurement', $goodsReceipt->goods_receipt_number, $oldValues, $data);
        }

        return $result;
    }

    public function delete(GoodsReceipt $goodsReceipt): bool
    {
        $this->auditService->logDelete('procurement', $goodsReceipt->goods_receipt_number, $goodsReceipt->toArray());
        return $this->goodsReceiptRepository->delete($goodsReceipt);
    }

    public function complete(GoodsReceipt $goodsReceipt): bool
    {
        $goodsReceipt->status = 'completed';
        $result = $goodsReceipt->save();

        if ($result) {
            $this->auditService->logComplete('procurement', $goodsReceipt->goods_receipt_number);
        }

        return $result;
    }

    public function cancel(GoodsReceipt $goodsReceipt): bool
    {
        $goodsReceipt->status = 'cancelled';
        $result = $goodsReceipt->save();

        if ($result) {
            $this->auditService->logCancel('procurement', $goodsReceipt->goods_receipt_number);
        }

        return $result;
    }

    public function findByPurchaseOrder(int $purchaseOrderId)
    {
        return $this->goodsReceiptRepository->findByPurchaseOrder($purchaseOrderId);
    }

    public function findByStatus(string $status)
    {
        return $this->goodsReceiptRepository->findByStatus($status);
    }
}

