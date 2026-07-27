<?php

namespace Modules\Accounting\Repositories;

use App\Repositories\BaseRepository;
use Modules\Accounting\Models\PostingQueue;

class PostingQueueRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return PostingQueue::class;
    }

    public function findPendingItems()
    {
        return $this->model->where('status', 'pending')
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function findFailedItems()
    {
        return $this->model->where('status', 'failed')
            ->orderBy('retry_count', 'desc')
            ->get();
    }
}
