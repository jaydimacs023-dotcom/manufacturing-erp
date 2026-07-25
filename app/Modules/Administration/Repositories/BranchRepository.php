<?php

namespace Modules\Administration\Repositories;

use App\Repositories\BaseRepository;
use Modules\Administration\Models\Branch;

class BranchRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return Branch::class;
    }

    public function findActive()
    {
        return $this->model->where('is_active', true)->get();
    }
}

