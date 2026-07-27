<?php

namespace Modules\Manufacturing\Repositories;

use App\Repositories\BaseRepository;
use Modules\Manufacturing\Models\BillOfMaterial;

class BillOfMaterialRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return BillOfMaterial::class;
    }

    public function findByProduct(int $productId)
    {
        return $this->model->where('product_id', $productId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function findActiveByProduct(int $productId)
    {
        return $this->model->where('product_id', $productId)
            ->where('status', 'approved')
            ->where('is_active', true)
            ->first();
    }

    public function findByStatus(string $status)
    {
        return $this->model->where('status', $status)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
