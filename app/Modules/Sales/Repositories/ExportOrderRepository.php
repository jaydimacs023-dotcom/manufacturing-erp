<?php

namespace Modules\Sales\Repositories;

use App\Repositories\BaseRepository;
use Modules\Sales\Models\ExportOrder;

class ExportOrderRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return ExportOrder::class;
    }

    public function findByStatus(string $status)
    {
        return $this->model->where('status', $status)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function findPendingShipments()
    {
        return $this->model->whereIn('status', ['planned', 'loaded', 'dispatched', 'in_transit'])
            ->orderBy('etd', 'asc')
            ->get();
    }

    public function findByDateRange($startDate, $endDate)
    {
        return $this->model->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function findByCustomer(int $customerId)
    {
        return $this->model->where('customer_id', $customerId)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}

