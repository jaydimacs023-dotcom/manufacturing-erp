<?php

namespace Modules\Administration\Repositories;

use App\Repositories\BaseRepository;
use Modules\Administration\Models\Warehouse;

class WarehouseRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return Warehouse::class;
    }

    public function findActive()
    {
        return $this->model->where('is_active', true)->get();
    }
}

