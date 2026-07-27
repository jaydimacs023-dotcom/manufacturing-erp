<?php

namespace Modules\Accounting\Repositories;

use App\Repositories\BaseRepository;
use Modules\Accounting\Models\AccountingEvent;

class AccountingEventRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return AccountingEvent::class;
    }

    public function findByStatus(string $status)
    {
        return $this->model->where('status', $status)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function findPendingEvents()
    {
        return $this->model->whereIn('status', ['pending', 'failed'])
            ->orderBy('posting_date', 'asc')
            ->get();
    }

    public function findByTransaction(string $transactionType, string $transactionNumber)
    {
        return $this->model->where('transaction_type', $transactionType)
            ->where('transaction_number', $transactionNumber)
            ->first();
    }

    public function findBySourceModule(string $module)
    {
        return $this->model->where('source_module', $module)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function findPostingsByDateRange($startDate, $endDate)
    {
        return $this->model->whereBetween('posting_date', [$startDate, $endDate])
            ->orderBy('posting_date', 'desc')
            ->get();
    }

    public function findTodayPostings()
    {
        return $this->model->whereDate('posting_date', today())
            ->orderBy('created_at', 'asc')
            ->get();
    }
}
