<?php

namespace Modules\Warehouse\Repositories;

use App\Repositories\BaseRepository;
use Modules\Warehouse\Models\StorageLocation;

class StorageLocationRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return StorageLocation::class;
    }

    public function findByWarehouse(int $warehouseId)
    {
        return $this->model->where('warehouse_id', $warehouseId)
            ->where('is_active', true)
            ->orderBy('location_code')
            ->get();
    }

    public function findByArea(string $area)
    {
        return $this->model->where('storage_area', $area)
            ->where('is_active', true)
            ->get();
    }

    public function findActive()
    {
        return $this->model->where('is_active', true)
            ->orderBy('storage_area')
            ->orderBy('rack')
            ->orderBy('bin')
            ->get();
    }
}

