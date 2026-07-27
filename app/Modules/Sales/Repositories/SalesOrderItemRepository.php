<?php

namespace Modules\Sales\Repositories;

use App\Repositories\BaseRepository;
use Modules\Sales\Models\SalesOrderItem;

class SalesOrderItemRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return SalesOrderItem::class;
    }

    public function findBySalesOrder(int $salesOrderId)
    {
        return $this->model->where('sales_order_id', $salesOrderId)
            ->with('product')
            ->get();
    }
}

