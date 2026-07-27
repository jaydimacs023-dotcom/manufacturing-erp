<?php

namespace Modules\Sales\Repositories;

use App\Repositories\BaseRepository;
use Modules\Sales\Models\ExportOrderItem;

class ExportOrderItemRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return ExportOrderItem::class;
    }

    public function findByExportOrder(int $exportOrderId)
    {
        return $this->model->where('export_order_id', $exportOrderId)
            ->with(['product', 'salesOrder'])
            ->get();
    }
}

