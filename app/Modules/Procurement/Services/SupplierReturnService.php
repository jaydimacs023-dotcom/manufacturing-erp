<?php

namespace Modules\Procurement\Services;

use App\Services\AuditService;
use App\Services\NumberSeriesService;
use Modules\Procurement\Models\SupplierReturn;
use Modules\Procurement\Repositories\SupplierReturnRepository;
use Modules\Procurement\Repositories\SupplierReturnItemRepository;

class SupplierReturnService
{
    public function __construct(
        protected SupplierReturnRepository $supplierReturnRepository,
        protected SupplierReturnItemRepository $supplierReturnItemRepository,
        protected NumberSeriesService $numberSeriesService,
        protected AuditService $auditService,
    ) {}

    public function getPaginated(int $perPage = 15)
    {
        return $this->supplierReturnRepository->paginate($perPage);
    }

    public function findById(int $id): ?SupplierReturn
    {
        return $this->supplierReturnRepository->find($id);
    }

    public function create(array $data): SupplierReturn
    {
        if (!isset($data['supplier_return_number'])) {
            $data['supplier_return_number'] = $this->numberSeriesService->generateNext('SR');
        }
        if (!isset($data['status'])) {
            $data['status'] = 'draft';
        }

        $supplierReturn = $this->supplierReturnRepository->create($data);

        $this->auditService->logCreate('procurement', $supplierReturn->supplier_return_number, $data);

        return $supplierReturn;
    }

    public function update(SupplierReturn $supplierReturn, array $data): bool
    {
        $oldValues = $supplierReturn->toArray();
        $result = $this->supplierReturnRepository->update($supplierReturn, $data);

        if ($result) {
            $this->auditService->logUpdate('procurement', $supplierReturn->supplier_return_number, $oldValues, $data);
        }

        return $result;
    }

    public function delete(SupplierReturn $supplierReturn): bool
    {
        $this->auditService->logDelete('procurement', $supplierReturn->supplier_return_number, $supplierReturn->toArray());
        return $this->supplierReturnRepository->delete($supplierReturn);
    }

    public function complete(SupplierReturn $supplierReturn): bool
    {
        $supplierReturn->status = 'completed';
        $result = $supplierReturn->save();

        if ($result) {
            $this->auditService->logComplete('procurement', $supplierReturn->supplier_return_number);
        }

        return $result;
    }

    public function cancel(SupplierReturn $supplierReturn): bool
    {
        $supplierReturn->status = 'cancelled';
        $result = $supplierReturn->save();

        if ($result) {
            $this->auditService->logCancel('procurement', $supplierReturn->supplier_return_number);
        }

        return $result;
    }

    public function findByStatus(string $status)
    {
        return $this->supplierReturnRepository->findByStatus($status);
    }

    public function findByGoodsReceipt(int $goodsReceiptId)
    {
        return $this->supplierReturnRepository->findByGoodsReceipt($goodsReceiptId);
    }
}

