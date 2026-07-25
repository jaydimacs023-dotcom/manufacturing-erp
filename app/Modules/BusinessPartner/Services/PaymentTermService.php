<?php

namespace Modules\BusinessPartner\Services;

use App\Services\NumberSeriesService;
use Modules\BusinessPartner\Models\PaymentTerm;
use Modules\BusinessPartner\Repositories\PaymentTermRepository;

class PaymentTermService
{
    public function __construct(
        protected PaymentTermRepository $paymentTermRepository,
        protected NumberSeriesService $numberSeriesService,
    ) {}

    public function getAll()
    {
        return $this->paymentTermRepository->all();
    }

    public function getPaginated(int $perPage = 15)
    {
        return $this->paymentTermRepository->paginate($perPage);
    }

    public function findById(int $id): ?PaymentTerm
    {
        return $this->paymentTermRepository->find($id);
    }

    public function create(array $data): PaymentTerm
    {
        if (!isset($data['term_code'])) {
            $data['term_code'] = $this->numberSeriesService->generateNext('PAYMENT_TERM');
        }
        return $this->paymentTermRepository->create($data);
    }

    public function update(PaymentTerm $paymentTerm, array $data): bool
    {
        return $this->paymentTermRepository->update($paymentTerm, $data);
    }

    public function delete(PaymentTerm $paymentTerm): bool
    {
        return $this->paymentTermRepository->delete($paymentTerm);
    }

    public function getActiveTerms()
    {
        return $this->paymentTermRepository->findActive();
    }
}

