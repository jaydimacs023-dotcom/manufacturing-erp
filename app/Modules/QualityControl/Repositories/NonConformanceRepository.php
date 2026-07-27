<?php

namespace Modules\QualityControl\Repositories;

use App\Repositories\BaseRepository;
use Modules\QualityControl\Models\NonConformance;

class NonConformanceRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return NonConformance::class;
    }

    public function findByStatus(string $status)
    {
        return $this->model->where('status', $status)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function findBySeverity(string $severity)
    {
        return $this->model->where('severity', $severity)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function findByInspection(int $inspectionId)
    {
        return $this->model->where('quality_inspection_id', $inspectionId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function findOpen()
    {
        return $this->model->whereIn('status', ['open', 'in_progress'])
            ->orderBy('created_at', 'desc')
            ->get();
    }
}

