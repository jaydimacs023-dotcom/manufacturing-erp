<?php

namespace Modules\Manufacturing\Repositories;

use App\Repositories\BaseRepository;
use Modules\Manufacturing\Models\ProductionOutput;

class ProductionOutputRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return ProductionOutput::class;
    }

    public function findByMo(int $moId)
    {
        return $this->model->where('manufacturing_order_id', $moId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function findPendingQc()
    {
        return $this->model->where('status', 'pending_qc')
            ->orderBy('created_at', 'asc')
            ->get();
    }
}
