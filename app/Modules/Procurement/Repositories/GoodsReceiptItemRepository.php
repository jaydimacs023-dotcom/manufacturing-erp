<?php

namespace Modules\Procurement\Repositories;

use App\Repositories\BaseRepository;
use Modules\Procurement\Models\GoodsReceiptItem;

class GoodsReceiptItemRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return GoodsReceiptItem::class;
    }

    public function findByGoodsReceipt(int $goodsReceiptId)
    {
        return $this->model->where('goods_receipt_id', $goodsReceiptId)->get();
    }
}

