<?php

namespace Modules\ProductMaster\Repositories;

use App\Repositories\BaseRepository;
use Modules\ProductMaster\Models\ProductSpecification;

class ProductSpecificationRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return ProductSpecification::class;
    }

    public function findByProduct(int $productId)
    {
        return $this->model->where('product_id', $productId)->get();
    }
}

