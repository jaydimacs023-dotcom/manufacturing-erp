<?php

namespace Modules\Manufacturing\Repositories;

use App\Repositories\BaseRepository;
use Modules\Manufacturing\Models\ManufacturingOrder;

class ManufacturingOrderRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return ManufacturingOrder::class;
    }

    public function findByStatus(string $status)
    {
        return $this->model->where('status', $status)
            ->orderBy('planned_start_date', 'asc')
            ->get();
    }

    public function findPendingProduction()
    {
        return $this->model->whereIn('status', ['released', 'in_progress'])
            ->orderBy('planned_start_date', 'asc')
            ->get();
    }

    public function findByProduct(int $productId)
    {
        return $this->model->where('product_id', $productId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function findTodayOrders()
    {
        return $this->model->whereDate('planned_start_date', today())
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function findInProgress()
    {
        return $this->model->where('status', 'in_progress')
            ->orderBy('actual_start_date', 'asc')
            ->get();
    }
}
