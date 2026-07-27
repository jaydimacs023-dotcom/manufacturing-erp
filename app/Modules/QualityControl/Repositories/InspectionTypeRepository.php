<?php

namespace Modules\QualityControl\Repositories;

use App\Repositories\BaseRepository;
use Modules\QualityControl\Models\InspectionType;

class InspectionTypeRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return InspectionType::class;
    }

    public function findByCategory(string $category)
    {
        return $this->model->where('category', $category)
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

