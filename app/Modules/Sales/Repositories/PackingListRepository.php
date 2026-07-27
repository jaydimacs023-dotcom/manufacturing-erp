<?php

namespace Modules\Sales\Repositories;

use App\Repositories\BaseRepository;
use Modules\Sales\Models\PackingList;

class PackingListRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return PackingList::class;
    }

    public function findByExportOrder(int $exportOrderId)
    {
        return $this->model->where('export_order_id', $exportOrderId)
            ->with('product')
            ->get();
    }
}

