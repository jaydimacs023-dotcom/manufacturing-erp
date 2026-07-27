<?php

namespace Modules\Manufacturing\Repositories;

use App\Repositories\BaseRepository;
use Modules\Manufacturing\Models\MaterialIssue;

class MaterialIssueRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return MaterialIssue::class;
    }

    public function findByMo(int $moId)
    {
        return $this->model->where('manufacturing_order_id', $moId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function findByStatus(string $status)
    {
        return $this->model->where('status', $status)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
