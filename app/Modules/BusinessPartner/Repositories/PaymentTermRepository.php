<?php

namespace Modules\BusinessPartner\Repositories;

use App\Repositories\BaseRepository;
use Modules\BusinessPartner\Models\PaymentTerm;

class PaymentTermRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return PaymentTerm::class;
    }

    public function findActive()
    {
        return $this->model->where('is_active', true)->get();
    }
}

