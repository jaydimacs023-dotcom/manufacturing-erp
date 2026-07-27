<?php

namespace Modules\QualityControl\Repositories;

use App\Repositories\BaseRepository;
use Modules\QualityControl\Models\QualityInspectionItem;

class QualityInspectionItemRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return QualityInspectionItem::class;
    }

    public function findByInspection(int $inspectionId)
    {
        return $this->model->where('quality_inspection_id', $inspectionId)
            ->orderBy('sort_order')
            ->get();
    }

    public function findFailedByInspection(int $inspectionId)
    {
        return $this->model->where('quality_inspection_id', $inspectionId)
            ->where('result', 'fail')
            ->get();
    }
}

