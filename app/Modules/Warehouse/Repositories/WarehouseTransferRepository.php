<?php

namespace Modules\Warehouse\Repositories;

use App\Repositories\BaseRepository;
use Modules\Warehouse\Models\WarehouseTransfer;

class WarehouseTransferRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return WarehouseTransfer::class;
    }

    public function findByStatus(string $status)
    {
        return $this->model->where('status', $status)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function findPendingApproval()
    {
        return $this->model->where('status', 'draft')
            ->orderBy('created_at', 'asc')
            ->get();
    }
}

