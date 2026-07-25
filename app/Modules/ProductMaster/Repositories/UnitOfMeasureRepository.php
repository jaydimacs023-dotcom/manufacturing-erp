<?php

namespace Modules\ProductMaster\Repositories;

use App\Repositories\BaseRepository;
use Modules\ProductMaster\Models\UnitOfMeasure;

class UnitOfMeasureRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return UnitOfMeasure::class;
    }

    public function findActive()
    {
        return $this->model->where('is_active', true)->get();
    }
}

