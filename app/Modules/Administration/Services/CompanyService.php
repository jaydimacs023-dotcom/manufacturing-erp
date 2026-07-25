<?php

namespace Modules\Administration\Services;

use Modules\Administration\Models\Company;
use Modules\Administration\Repositories\CompanyRepository;

class CompanyService
{
    public function __construct(
        protected CompanyRepository $companyRepository,
    ) {}

    public function getActive(): ?Company
    {
        return $this->companyRepository->getActive();
    }

    public function findById(int $id): ?Company
    {
        return $this->companyRepository->find($id);
    }

    public function create(array $data): Company
    {
        return $this->companyRepository->create($data);
    }

    public function update(Company $company, array $data): bool
    {
        return $this->companyRepository->update($company, $data);
    }
}

