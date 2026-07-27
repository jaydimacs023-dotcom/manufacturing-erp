<?php

namespace Modules\Procurement\Repositories;

use App\Repositories\BaseRepository;
use Modules\Procurement\Models\PurchaseOrder;

class PurchaseOrderRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return PurchaseOrder::class;
    }

    public function findOpen()
    {
        return $this->model->whereIn('status', ['approved', 'sent', 'partially_received'])->get();
    }

    public function findByStatus(string $status)
    {
        return $this->model->where('status', $status)->get();
    }

    public function findPendingApproval()
    {
        return $this->model->where('status', 'draft')->orWhere('status', 'submitted')->get();
    }

    public function findBySupplier(int $supplierId)
    {
        return $this->model->where('supplier_id', $supplierId)->get();
    }
}

