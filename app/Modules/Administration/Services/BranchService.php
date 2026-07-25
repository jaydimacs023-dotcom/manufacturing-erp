<?php

namespace Modules\Administration\Services;

use App\Services\NumberSeriesService;
use Modules\Administration\Models\Branch;
use Modules\Administration\Repositories\BranchRepository;

class BranchService
{
    public function __construct(
        protected BranchRepository $branchRepository,
        protected NumberSeriesService $numberSeriesService,
    ) {}

    public function getAll()
    {
        return $this->branchRepository->all();
    }

    public function getPaginated(int $perPage = 15)
    {
        return $this->branchRepository->paginate($perPage);
    }

    public function findById(int $id): ?Branch
    {
        return $this->branchRepository->find($id);
    }

    public function create(array $data): Branch
    {
        if (!isset($data['branch_code'])) {
            $data['branch_code'] = $this->numberSeriesService->generateNext('BRANCH');
        }
        return $this->branchRepository->create($data);
    }

    public function update(Branch $branch, array $data): bool
    {
        return $this->branchRepository->update($branch, $data);
    }

    public function delete(Branch $branch): bool
    {
        return $this->branchRepository->delete($branch);
    }

    public function getActiveBranches()
    {
        return $this->branchRepository->findActive();
    }
}

