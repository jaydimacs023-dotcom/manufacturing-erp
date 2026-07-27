<?php

namespace Modules\Manufacturing\Repositories;

use App\Repositories\BaseRepository;
use Modules\Manufacturing\Models\BillOfMaterialItem;

class BillOfMaterialItemRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return BillOfMaterialItem::class;
    }

    public function findByBom(int $bomId)
    {
        return $this->model->where('bill_of_material_id', $bomId)->get();
    }

    public function deleteByBom(int $bomId)
    {
        return $this->model->where('bill_of_material_id', $bomId)->delete();
    }
}
