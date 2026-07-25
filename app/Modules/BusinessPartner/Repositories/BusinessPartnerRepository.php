<?php

namespace Modules\BusinessPartner\Repositories;

use App\Repositories\BaseRepository;
use Modules\BusinessPartner\Models\BusinessPartner;

class BusinessPartnerRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return BusinessPartner::class;
    }

    public function findActive()
    {
        return $this->model->where('is_active', true)->get();
    }

    public function findByType(string $type)
    {
        return $this->model->where('partner_type', $type)->get();
    }
}

