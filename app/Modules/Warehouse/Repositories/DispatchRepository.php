<?php

namespace Modules\Warehouse\Repositories;

use App\Repositories\BaseRepository;
use Modules\Warehouse\Models\Dispatch;

class DispatchRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return Dispatch::class;
    }

    public function findByStatus(string $status)
    {
        return $this->model->where('status', $status)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function findPendingDispatch()
    {
        return $this->model->whereIn('status', ['packed', 'loaded'])
            ->orderBy('dispatch_date', 'asc')
            ->get();
    }

    public function findByDateRange($startDate, $endDate)
    {
        return $this->model->whereBetween('dispatch_date', [$startDate, $endDate])
            ->orderBy('dispatch_date', 'desc')
            ->get();
    }

    public function findTodayDispatch()
    {
        return $this->model->whereDate('dispatch_date', today())
            ->orderBy('created_at', 'asc')
            ->get();
    }
}

