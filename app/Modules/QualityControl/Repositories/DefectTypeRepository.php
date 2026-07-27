<?php

namespace Modules\QualityControl\Repositories;

use App\Repositories\BaseRepository;
use Modules\QualityControl\Models\DefectType;

class DefectTypeRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return DefectType::class;
    }

    public function findBySeverity(string $severity)
    {
        return $this->model->where('severity', $severity)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
    }

    public function findActive()
    {
        return $this->model->where('is_active', true)
            ->orderBy('name')
            ->get();
    }
}

