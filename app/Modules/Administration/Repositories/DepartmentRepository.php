<?php

namespace Modules\Administration\Repositories;

use App\Repositories\BaseRepository;
use Modules\Administration\Models\Department;

class DepartmentRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return Department::class;
    }

    public function findActive()
    {
        return $this->model->where('is_active', true)->get();
    }
}

