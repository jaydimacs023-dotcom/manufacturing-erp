<?php

namespace Modules\Administration\Repositories;

use App\Repositories\BaseRepository;
use Modules\Administration\Models\Company;

class CompanyRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return Company::class;
    }

    public function getActive(): ?Company
    {
        return $this->model->where('is_active', true)->first();
    }
}

