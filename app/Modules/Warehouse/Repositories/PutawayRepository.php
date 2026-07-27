<?php

namespace Modules\Warehouse\Repositories;

use App\Repositories\BaseRepository;
use Modules\Warehouse\Models\Putaway;

class PutawayRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return Putaway::class;
    }

    public function findByStatus(string $status)
    {
        return $this->model->where('status', $status)
            ->orderBy('putaway_date', 'desc')
            ->get();
    }

    public function findPending()
    {
        return $this->model->where('status', 'pending')
            ->orderBy('putaway_date', 'asc')
            ->get();
    }

    public function findByDateRange($startDate, $endDate)
    {
        return $this->model->whereBetween('putaway_date', [$startDate, $endDate])
            ->orderBy('putaway_date', 'desc')
            ->get();
    }
}

