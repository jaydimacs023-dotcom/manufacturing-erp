<?php

namespace Modules\QualityControl\Repositories;

use App\Repositories\BaseRepository;
use Modules\QualityControl\Models\CorrectiveAction;

class CorrectiveActionRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return CorrectiveAction::class;
    }

    public function findByStatus(string $status)
    {
        return $this->model->where('status', $status)
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
            ->orderBy('due_date', 'asc')
            ->get();
    }

    public function findOverdue()
    {
        return $this->model->whereIn('status', ['open', 'in_progress'])
            ->where('due_date', '<', now())
            ->orderBy('due_date', 'asc')
            ->get();
    }
}

