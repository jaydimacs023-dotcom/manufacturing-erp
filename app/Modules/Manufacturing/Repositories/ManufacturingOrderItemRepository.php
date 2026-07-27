<?php

namespace Modules\Manufacturing\Repositories;

use App\Repositories\BaseRepository;
use Modules\Manufacturing\Models\ManufacturingOrderItem;

class ManufacturingOrderItemRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return ManufacturingOrderItem::class;
    }

    public function findByMo(int $moId)
    {
        return $this->model->where('manufacturing_order_id', $moId)->get();
    }

    public function deleteByMo(int $moId)
    {
        return $this->model->where('manufacturing_order_id', $moId)->delete();
    }
}
