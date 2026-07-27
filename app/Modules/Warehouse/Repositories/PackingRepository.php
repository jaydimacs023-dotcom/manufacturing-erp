<?php

namespace Modules\Warehouse\Repositories;

use App\Repositories\BaseRepository;
use Modules\Warehouse\Models\Packing;

class PackingRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return Packing::class;
    }

    public function findByStatus(string $status)
    {
        return $this->model->where('status', $status)
            ->orderBy('packing_date', 'desc')
            ->get();
    }

    public function findByReference(string $referenceType, int $referenceId)
    {
        return $this->model->where('reference_type', $referenceType)
            ->where('reference_id', $referenceId)
            ->get();
    }
}

