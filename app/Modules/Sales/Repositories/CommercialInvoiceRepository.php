<?php

namespace Modules\Sales\Repositories;

use App\Repositories\BaseRepository;
use Modules\Sales\Models\CommercialInvoice;

class CommercialInvoiceRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return CommercialInvoice::class;
    }

    public function findByExportOrder(int $exportOrderId)
    {
        return $this->model->where('export_order_id', $exportOrderId)
            ->with('customer')
            ->get();
    }

    public function findByCustomer(int $customerId)
    {
        return $this->model->where('customer_id', $customerId)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}

