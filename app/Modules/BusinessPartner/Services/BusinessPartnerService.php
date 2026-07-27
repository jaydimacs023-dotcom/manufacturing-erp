<?php

namespace Modules\BusinessPartner\Services;

use App\Services\NumberSeriesService;
use Modules\BusinessPartner\Models\BusinessPartner;
use Modules\BusinessPartner\Repositories\BusinessPartnerRepository;

class BusinessPartnerService
{
    public function __construct(
        protected BusinessPartnerRepository $businessPartnerRepository,
        protected NumberSeriesService $numberSeriesService,
    ) {}

    public function getAll()
    {
        return $this->businessPartnerRepository->all();
    }

    public function getPaginated(int $perPage = 15)
    {
        return $this->businessPartnerRepository->paginate($perPage);
    }

    public function findById(int $id): ?BusinessPartner
    {
        return $this->businessPartnerRepository->find($id);
    }

    public function create(array $data): BusinessPartner
    {
        if (!isset($data['partner_code'])) {
            $prefix = $this->getPrefixForType($data['partner_type'] ?? 'supplier');
            $data['partner_code'] = $this->numberSeriesService->generateNext($prefix);
        }
        return $this->businessPartnerRepository->create($data);
    }

    public function update(BusinessPartner $businessPartner, array $data): bool
    {
        return $this->businessPartnerRepository->update($businessPartner, $data);
    }

    public function delete(BusinessPartner $businessPartner): bool
    {
        return $this->businessPartnerRepository->delete($businessPartner);
    }

    public function getActivePartners()
    {
        return $this->businessPartnerRepository->findActive();
    }

    public function getByType(string $type)
    {
        return $this->businessPartnerRepository->findByType($type);
    }

    public function getSuppliers()
    {
        return $this->businessPartnerRepository->findByType('supplier');
    }

    private function getPrefixForType(string $type): string
    {
        $prefixes = [
            'supplier' => 'SUPPLIER',
            'customer' => 'CUSTOMER',
            'freight_forwarder' => 'FORWARDER',
            'customs_broker' => 'BROKER',
            'service_provider' => 'SERVICE',
        ];

        return $prefixes[$type] ?? 'PARTNER';
    }
}

