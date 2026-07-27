<?php

namespace Modules\Accounting\Repositories;

use App\Repositories\BaseRepository;
use Modules\Accounting\Models\AccountMapping;

class AccountMappingRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return AccountMapping::class;
    }

    public function findBySourceType(string $sourceType)
    {
        return $this->model->where('source_type', $sourceType)
            ->where('is_active', true)
            ->get();
    }

    public function findActiveMappings()
    {
        return $this->model->where('is_active', true)
            ->orderBy('mapping_type')
            ->orderBy('direction')
            ->get();
    }
}
