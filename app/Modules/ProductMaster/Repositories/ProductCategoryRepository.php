<?php

namespace Modules\ProductMaster\Repositories;

use App\Repositories\BaseRepository;
use Modules\ProductMaster\Models\ProductCategory;

class ProductCategoryRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return ProductCategory::class;
    }

    public function findActive()
    {
        return $this->model->where('is_active', true)->get();
    }
}

