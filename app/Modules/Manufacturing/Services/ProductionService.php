<?php

namespace Modules\Manufacturing\Services;

use App\Services\AuditService;
use App\Services\NumberSeriesService;
use Modules\Manufacturing\Models\ManufacturingOrder;
use Modules\Manufacturing\Models\MaterialIssue;
use Modules\Manufacturing\Models\ProductionOutput;
use Modules\Manufacturing\Repositories\MaterialIssueRepository;
use Modules\Manufacturing\Repositories\MaterialIssueItemRepository;
use Modules\Manufacturing\Repositories\ProductionOutputRepository;
use Modules\Manufacturing\Repositories\WasteRecordRepository;
use Modules\Manufacturing\Enums\ManufacturingOrderStatus;
use Modules\Inventory\Services\InventoryService;

class ProductionService
{
    public function __construct(
        protected MaterialIssueRepository $materialIssueRepository,
        protected MaterialIssueItemRepository $materialIssueItemRepository,
        protected ProductionOutputRepository $productionOutputRepository,
        protected WasteRecordRepository $wasteRecordRepository,
        protected ManufacturingOrderService $manufacturingOrderService,
        protected InventoryService $inventoryService,
        protected NumberSeriesService $numberSeriesService,
        protected AuditService $auditService,
    ) {}

    public function getPaginated(int $perPage = 15)
    {
        return $this->materialIssueRepository->paginate($perPage);
    }

    public function getOutputsPaginated(int $perPage = 15)
    {
        return $this->productionOutputRepository->paginate($perPage);
    }

    public function getWastePaginated(int $perPage = 15)
    {
        return $this->wasteRecordRepository->paginate($perPage);
    }

    /**
     * Issue materials to a manufacturing order.
     */
    public function issueMaterials(array $data): MaterialIssue
    {
        if (!isset($data['issue_number'])) {
            $data['issue_number'] = $this->numberSeriesService->generateNext('MATERIAL_ISSUE');
        }
        if (!isset($data['status'])) {
            $data['status'] = 'completed';
        }
        if (!isset($data['issue_date'])) {
            $data['issue_date'] = now()->format('Y-m-d');
        }

        $issue = $this->materialIssueRepository->create($data);

        // Create issue items and update inventory
        if (isset($data['items']) && is_array($data['items'])) {
            foreach ($data['items'] as $item) {
                $item['material_issue_id'] = $issue->id;
                $item['total_cost'] = ($item['unit_cost'] ?? 0) * ($item['quantity_issued'] ?? 0);
                $this->materialIssueItemRepository->create($item);

                // Record inventory movement for material issue
                $this->inventoryService->recordMovement([
                    'movement_type' => 'production_issue',
                    'product_id' => $item['product_id'],
                    'warehouse_id' => $data['warehouse_id'],
                    'uom_id' => $item['uom_id'],
                    'quantity' => $item['quantity_issued'],
                    'unit_cost' => $item['unit_cost'] ?? 0,
                    'batch_number' => $item['batch_number'] ?? null,
                    'reference_type' => 'material_issue',
                    'reference_id' => $issue->id,
                    'remarks' => "Material Issue: {$issue->issue_number}",
                ]);

                // Update MO item issued quantity
                if (isset($item['manufacturing_order_item_id'])) {
                    $moItem = \Modules\Manufacturing\Models\ManufacturingOrderItem::find($item['manufacturing_order_item_id']);
                    if ($moItem) {
                        $moItem->issued_quantity += $item['quantity_issued'];
                        $moItem->save();
                    }
                }
            }
        }

        $this->auditService->logCreate('manufacturing', $issue->issue_number, $data);

        return $issue;
    }

    /**
     * Record production output (finished goods).
     */
    public function recordOutput(array $data): ProductionOutput
    {
        if (!isset($data['output_number'])) {
            $data['output_number'] = $this->numberSeriesService->generateNext('PRODUCTION_OUTPUT');
        }
        if (!isset($data['status'])) {
            $data['status'] = 'pending_qc';
        }

        // Calculate yield percentage
        $mo = ManufacturingOrder::find($data['manufacturing_order_id']);
        if ($mo && $mo->planned_quantity > 0) {
            $data['yield_percentage'] = ($data['quantity_produced'] / $mo->planned_quantity) * 100;
        }

        $output = $this->productionOutputRepository->create($data);

        // Record finished goods to inventory (pending QC - will be quarantined)
        $this->inventoryService->recordMovement([
            'movement_type' => 'finished_goods_receipt',
            'product_id' => $data['product_id'],
            'warehouse_id' => $data['warehouse_id'],
            'uom_id' => $data['uom_id'],
            'quantity' => $data['quantity_produced'],
            'unit_cost' => 0,
            'batch_number' => $data['batch_number'] ?? null,
            'reference_type' => 'production_output',
            'reference_id' => $output->id,
            'remarks' => "Production Output: {$output->output_number}",
        ]);

        $this->auditService->logCreate('manufacturing', $output->output_number, $data);

        return $output;
    }

    /**
     * Approve production output (QC approval).
     */
    public function approveOutput(ProductionOutput $output, ?string $remarks = null): bool
    {
        $output->status = 'approved';
        $output->inspected_by = auth()->id();
        $output->inspected_at = now();
        if ($remarks) {
            $output->qc_remarks = $remarks;
        }
        $result = $output->save();

        if ($result) {
            $this->auditService->logApprove('manufacturing', $output->output_number);
        }

        return $result;
    }

    /**
     * Reject production output.
     */
    public function rejectOutput(ProductionOutput $output, string $reason): bool
    {
        $output->status = 'rejected';
        $output->inspected_by = auth()->id();
        $output->inspected_at = now();
        $output->qc_remarks = $reason;
        $result = $output->save();

        if ($result) {
            $this->auditService->logReject('manufacturing', $output->output_number, $reason);
        }

        return $result;
    }

    /**
     * Record waste from production.
     */
    public function recordWaste(array $data): \Modules\Manufacturing\Models\WasteRecord
    {
        if (!isset($data['waste_number'])) {
            $data['waste_number'] = $this->numberSeriesService->generateNext('WASTE_RECORD');
        }

        $waste = $this->wasteRecordRepository->create($data);

        $this->auditService->logCreate('manufacturing', $waste->waste_number, $data);

        return $waste;
    }

    public function getIssuesByMo(int $moId)
    {
        return $this->materialIssueRepository->findByMo($moId);
    }

    public function getOutputsByMo(int $moId)
    {
        return $this->productionOutputRepository->findByMo($moId);
    }

    public function getWasteByMo(int $moId)
    {
        return $this->wasteRecordRepository->findByMo($moId);
    }
}
