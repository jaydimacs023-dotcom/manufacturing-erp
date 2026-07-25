<?php

namespace Modules\BusinessPartner\Repositories;

use App\Repositories\BaseRepository;
use Modules\BusinessPartner\Models\ContactPerson;

class ContactPersonRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return ContactPerson::class;
    }

    public function findByPartner(int $partnerId)
    {
        return $this->model->where('business_partner_id', $partnerId)->get();
    }
}

