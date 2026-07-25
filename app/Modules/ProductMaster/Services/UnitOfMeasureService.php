<?php

namespace Modules\ProductMaster\Services;

use Modules\ProductMaster\Models\UnitOfMeasure;
use Modules\ProductMaster\Repositories\UnitOfMeasureRepository;

class UnitOfMeasureService
{
    public function __construct(
        protected UnitOfMeasureRepository $uomRepository,
    ) {}

    public function getAll()
    {
        return $this->uomRepository->all();
    }

    public function getPaginated(int $perPage = 15)
    {
        return $this->uomRepository->paginate($perPage);
    }

    public function findById(int $id): ?UnitOfMeasure
    {
        return $this->uomRepository->find($id);
    }

    public function create(array $data): UnitOfMeasure
    {
        return $this->uomRepository->create($data);
    }

    public function update(UnitOfMeasure $uom, array $data): bool
    {
        return $this->uomRepository->update($uom, $data);
    }

    public function delete(UnitOfMeasure $uom): bool
    {
        return $this->uomRepository->delete($uom);
    }

    public function getActiveUoms()
    {
        return $this->uomRepository->findActive();
    }
}

