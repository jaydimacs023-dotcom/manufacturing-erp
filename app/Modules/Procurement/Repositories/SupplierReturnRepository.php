<?php

namespace Modules\Procurement\Repositories;

use App\Repositories\BaseRepository;
use Modules\Procurement\Models\SupplierReturn;

class SupplierReturnRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return SupplierReturn::class;
    }

    public function findByGoodsReceipt(int $goodsReceiptId)
    {
        return $this->model->where('goods_receipt_id', $goodsReceiptId)->get();
    }

    public function findByStatus(string $status)
    {
        return $this->model->where('status', $status)->get();
    }
}

