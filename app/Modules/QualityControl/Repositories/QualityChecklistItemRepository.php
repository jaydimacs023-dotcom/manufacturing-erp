<?php

namespace Modules\QualityControl\Repositories;

use App\Repositories\BaseRepository;
use Modules\QualityControl\Models\QualityChecklistItem;

class QualityChecklistItemRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return QualityChecklistItem::class;
    }

    public function findByChecklist(int $checklistId)
    {
        return $this->model->where('quality_checklist_id', $checklistId)
            ->orderBy('sort_order')
            ->get();
    }
}

