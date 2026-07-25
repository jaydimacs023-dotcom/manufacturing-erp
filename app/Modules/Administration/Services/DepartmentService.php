<?php

namespace Modules\Administration\Services;

use App\Services\NumberSeriesService;
use Modules\Administration\Models\Department;
use Modules\Administration\Repositories\DepartmentRepository;

class DepartmentService
{
    public function __construct(
        protected DepartmentRepository $departmentRepository,
        protected NumberSeriesService $numberSeriesService,
    ) {}

    public function getAll()
    {
        return $this->departmentRepository->all();
    }

    public function getPaginated(int $perPage = 15)
    {
        return $this->departmentRepository->paginate($perPage);
    }

    public function findById(int $id): ?Department
    {
        return $this->departmentRepository->find($id);
    }

    public function create(array $data): Department
    {
        if (!isset($data['department_code'])) {
            $data['department_code'] = $this->numberSeriesService->generateNext('DEPARTMENT');
        }
        return $this->departmentRepository->create($data);
    }

    public function update(Department $department, array $data): bool
    {
        return $this->departmentRepository->update($department, $data);
    }

    public function delete(Department $department): bool
    {
        return $this->departmentRepository->delete($department);
    }

    public function getActiveDepartments()
    {
        return $this->departmentRepository->findActive();
    }
}

