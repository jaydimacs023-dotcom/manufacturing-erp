<?php

namespace Modules\Procurement\Repositories;

use App\Repositories\BaseRepository;
use Modules\Procurement\Models\SupplierReturnItem;

class SupplierReturnItemRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return SupplierReturnItem::class;
    }

    public function findBySupplierReturn(int $supplierReturnId)
    {
        return $this->model->where('supplier_return_id', $supplierReturnId)->get();
    }
}

