<?php

namespace Modules\Sales\Services;

use App\Services\AuditService;
use App\Services\NumberSeriesService;
use Modules\Sales\Models\PackingList;
use Modules\Sales\Models\CommercialInvoice;
use Modules\Sales\Repositories\PackingListRepository;
use Modules\Sales\Repositories\CommercialInvoiceRepository;
use Modules\Sales\Enums\ShipmentStatus;

class ShipmentService
{
    public function __construct(
        protected PackingListRepository $packingListRepository,
        protected CommercialInvoiceRepository $commercialInvoiceRepository,
        protected NumberSeriesService $numberSeriesService,
        protected AuditService $auditService,
    ) {}

    public function getPackingListsPaginated(int $perPage = 15)
    {
        return $this->packingListRepository->paginate($perPage);
    }

    public function getInvoicesPaginated(int $perPage = 15)
    {
        return $this->commercialInvoiceRepository->paginate($perPage);
    }

    public function createPackingList(array $data): PackingList
    {
        if (!isset($data['packing_list_number'])) {
            $data['packing_list_number'] = $this->numberSeriesService->generateNext('PackingList');
        }
        $packingList = $this->packingListRepository->create($data);
        $this->auditService->logCreate('sales', $packingList->packing_list_number, $data);
        return $packingList;
    }

    public function deletePackingList(PackingList $packingList): bool
    {
        $this->auditService->logDelete('sales', $packingList->packing_list_number, $packingList->toArray());
        return $this->packingListRepository->delete($packingList);
    }

    public function createCommercialInvoice(array $data): CommercialInvoice
    {
        if (!isset($data['invoice_number'])) {
            $data['invoice_number'] = $this->numberSeriesService->generateNext('CommercialInvoice');
        }
        if (!isset($data['currency'])) {
            $data['currency'] = 'USD';
        }
        $invoice = $this->commercialInvoiceRepository->create($data);
        $this->auditService->logCreate('sales', $invoice->invoice_number, $data);
        return $invoice;
    }

    public function deleteCommercialInvoice(CommercialInvoice $invoice): bool
    {
        $this->auditService->logDelete('sales', $invoice->invoice_number, $invoice->toArray());
        return $this->commercialInvoiceRepository->delete($invoice);
    }
}

