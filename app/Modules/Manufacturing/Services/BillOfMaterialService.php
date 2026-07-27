<?php

namespace Modules\Manufacturing\Services;

use App\Services\AuditService;
use App\Services\NumberSeriesService;
use Modules\Manufacturing\Models\BillOfMaterial;
use Modules\Manufacturing\Repositories\BillOfMaterialRepository;
use Modules\Manufacturing\Repositories\BillOfMaterialItemRepository;

class BillOfMaterialService
{
    public function __construct(
        protected BillOfMaterialRepository $bomRepository,
        protected BillOfMaterialItemRepository $bomItemRepository,
        protected NumberSeriesService $numberSeriesService,
        protected AuditService $auditService,
    ) {}

    public function getPaginated(int $perPage = 15)
    {
        return $this->bomRepository->paginate($perPage);
    }

    public function findById(int $id): ?BillOfMaterial
    {
        return $this->bomRepository->find($id);
    }

    public function create(array $data): BillOfMaterial
    {
        if (!isset($data['bom_number'])) {
            $data['bom_number'] = $this->numberSeriesService->generateNext('BILL_OF_MATERIALS');
        }
        if (!isset($data['status'])) {
            $data['status'] = 'draft';
        }

        $bom = $this->bomRepository->create($data);

        // Create BOM items
        if (isset($data['items']) && is_array($data['items'])) {
            foreach ($data['items'] as $item) {
                $item['bill_of_material_id'] = $bom->id;
                $item['total_cost'] = ($item['unit_cost'] ?? 0) * ($item['quantity'] ?? 0);
                $this->bomItemRepository->create($item);
            }
        }

        $this->auditService->logCreate('manufacturing', $bom->bom_number, $data);

        return $bom;
    }

    public function update(BillOfMaterial $bom, array $data): bool
    {
        $oldValues = $bom->toArray();
        $result = $this->bomRepository->update($bom, $data);

        if ($result) {
            // Update items if provided
            if (isset($data['items']) && is_array($data['items'])) {
                $this->bomItemRepository->deleteByBom($bom->id);
                foreach ($data['items'] as $item) {
                    $item['bill_of_material_id'] = $bom->id;
                    $item['total_cost'] = ($item['unit_cost'] ?? 0) * ($item['quantity'] ?? 0);
                    $this->bomItemRepository->create($item);
                }
            }

            $this->auditService->logUpdate('manufacturing', $bom->bom_number, $oldValues, $data);
        }

        return $result;
    }

    public function delete(BillOfMaterial $bom): bool
    {
        $this->auditService->logDelete('manufacturing', $bom->bom_number, $bom->toArray());
        return $this->bomRepository->delete($bom);
    }

    public function approve(BillOfMaterial $bom): bool
    {
        $bom->status = 'approved';
        $result = $bom->save();

        if ($result) {
            $this->auditService->logApprove('manufacturing', $bom->bom_number);
        }

        return $result;
    }

    public function findActiveByProduct(int $productId)
    {
        return $this->bomRepository->findActiveByProduct($productId);
    }
}
