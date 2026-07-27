<?php

namespace Modules\QualityControl\Repositories;

use App\Repositories\BaseRepository;
use Modules\QualityControl\Models\QualityChecklist;

class QualityChecklistRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return QualityChecklist::class;
    }

    public function findByProduct(int $productId)
    {
        return $this->model->where('product_id', $productId)
            ->orWhereNull('product_id')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
    }

    public function findByInspectionType(int $inspectionTypeId)
    {
        return $this->model->where('inspection_type_id', $inspectionTypeId)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
    }

    public function findActive()
    {
        return $this->model->where('is_active', true)
            ->orderBy('name')
            ->get();
    }
}

