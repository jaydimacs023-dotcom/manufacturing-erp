<?php

namespace Modules\Procurement\Repositories;

use App\Repositories\BaseRepository;
use Modules\Procurement\Models\PurchaseRequest;

class PurchaseRequestRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return PurchaseRequest::class;
    }

    public function findPending()
    {
        return $this->model->whereIn('status', ['draft', 'submitted'])->get();
    }

    public function findByStatus(string $status)
    {
        return $this->model->where('status', $status)->get();
    }

    public function findPendingApproval()
    {
        return $this->model->where('status', 'submitted')->get();
    }
}

