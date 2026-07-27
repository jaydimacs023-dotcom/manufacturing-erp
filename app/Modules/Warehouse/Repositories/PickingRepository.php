<?php

namespace Modules\Warehouse\Repositories;

use App\Repositories\BaseRepository;
use Modules\Warehouse\Models\Picking;

class PickingRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return Picking::class;
    }

    public function findByStatus(string $status)
    {
        return $this->model->where('status', $status)
            ->orderBy('picking_date', 'desc')
            ->get();
    }

    public function findPending()
    {
        return $this->model->whereIn('status', ['pending', 'in_progress'])
            ->orderBy('picking_date', 'asc')
            ->get();
    }

    public function findByType(string $type)
    {
        return $this->model->where('picking_type', $type)
            ->orderBy('picking_date', 'desc')
            ->get();
    }

    public function findByReference(string $referenceType, int $referenceId)
    {
        return $this->model->where('reference_type', $referenceType)
            ->where('reference_id', $referenceId)
            ->get();
    }
}

