<?php

namespace Modules\QualityControl\Repositories;

use App\Repositories\BaseRepository;
use Modules\QualityControl\Models\QualityInspection;

class QualityInspectionRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return QualityInspection::class;
    }

    public function findByStatus(string $status)
    {
        return $this->model->where('status', $status)
            ->orderBy('inspection_date', 'desc')
            ->get();
    }

    public function findByType(string $type)
    {
        return $this->model->where('inspection_type', $type)
            ->orderBy('inspection_date', 'desc')
            ->get();
    }

    public function findPending()
    {
        return $this->model->whereIn('status', ['draft'])
            ->orderBy('inspection_date', 'asc')
            ->get();
    }

    public function findByProduct(int $productId)
    {
        return $this->model->where('product_id', $productId)
            ->orderBy('inspection_date', 'desc')
            ->get();
    }

    public function findByBatch(string $batchNumber)
    {
        return $this->model->where('batch_number', $batchNumber)
            ->orderBy('inspection_date', 'desc')
            ->get();
    }

    public function findTodayInspections()
    {
        return $this->model->whereDate('inspection_date', today())
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function findBySource(string $sourceType, int $sourceId)
    {
        return $this->model->where('inspection_source_type', $sourceType)
            ->where('inspection_source_id', $sourceId)
            ->orderBy('inspection_date', 'desc')
            ->get();
    }
}

