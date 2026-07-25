<?php

namespace Modules\Administration\Services;

use App\Services\NumberSeriesService;
use Modules\Administration\Models\Warehouse;
use Modules\Administration\Repositories\WarehouseRepository;

class WarehouseService
{
    public function __construct(
        protected WarehouseRepository $warehouseRepository,
        protected NumberSeriesService $numberSeriesService,
    ) {}

    public function getAll()
    {
        return $this->warehouseRepository->all();
    }

    public function getPaginated(int $perPage = 15)
    {
        return $this->warehouseRepository->paginate($perPage);
    }

    public function findById(int $id): ?Warehouse
    {
        return $this->warehouseRepository->find($id);
    }

    public function create(array $data): Warehouse
    {
        if (!isset($data['warehouse_code'])) {
            $data['warehouse_code'] = $this->numberSeriesService->generateNext('WAREHOUSE');
        }
        return $this->warehouseRepository->create($data);
    }

    public function update(Warehouse $warehouse, array $data): bool
    {
        return $this->warehouseRepository->update($warehouse, $data);
    }

    public function delete(Warehouse $warehouse): bool
    {
        return $this->warehouseRepository->delete($warehouse);
    }

    public function getActiveWarehouses()
    {
        return $this->warehouseRepository->findActive();
    }
}

