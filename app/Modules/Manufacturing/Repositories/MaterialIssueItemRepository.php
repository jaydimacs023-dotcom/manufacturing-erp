<?php

namespace Modules\Manufacturing\Repositories;

use App\Repositories\BaseRepository;
use Modules\Manufacturing\Models\MaterialIssueItem;

class MaterialIssueItemRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return MaterialIssueItem::class;
    }

    public function findByIssue(int $issueId)
    {
        return $this->model->where('material_issue_id', $issueId)->get();
    }
}
