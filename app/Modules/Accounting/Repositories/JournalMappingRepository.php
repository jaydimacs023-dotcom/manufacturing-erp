<?php

namespace Modules\Accounting\Repositories;

use App\Repositories\BaseRepository;
use Modules\Accounting\Models\JournalMapping;

class JournalMappingRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return JournalMapping::class;
    }

    public function findByTransactionType(string $transactionType)
    {
        return $this->model->where('transaction_type', $transactionType)
            ->where('is_active', true)
            ->first();
    }

    public function findActiveMappings()
    {
        return $this->model->where('is_active', true)
            ->orderBy('transaction_type')
            ->get();
    }
}
