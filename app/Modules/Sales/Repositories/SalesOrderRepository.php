<?php

namespace Modules\Sales\Repositories;

use App\Repositories\BaseRepository;
use Modules\Sales\Models\SalesOrder;

class SalesOrderRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return SalesOrder::class;
    }

    public function findByStatus(string $status)
    {
        return $this->model->where('status', $status)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function findPendingOrders()
    {
        return $this->model->whereIn('status', ['draft', 'confirmed', 'allocated'])
            ->orderBy('order_date', 'asc')
            ->get();
    }

    public function findByCustomer(int $customerId)
    {
        return $this->model->where('customer_id', $customerId)
            ->orderBy('order_date', 'desc')
            ->get();
    }

    public function findByDateRange($startDate, $endDate)
    {
        return $this->model->whereBetween('order_date', [$startDate, $endDate])
            ->orderBy('order_date', 'desc')
            ->get();
    }

    public function findOpenOrders()
    {
        return $this->model->whereNotIn('status', ['closed', 'cancelled'])
            ->orderBy('delivery_date', 'asc')
            ->get();
    }
}

