<?php

namespace Modules\ProductMaster\Repositories;

use App\Repositories\BaseRepository;
use Modules\ProductMaster\Models\Product;

class ProductRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return Product::class;
    }

    public function findActive()
    {
        return $this->model->where('is_active', true)->get();
    }

    public function findByType(string $type)
    {
        return $this->model->where('product_type', $type)->get();
    }
}

