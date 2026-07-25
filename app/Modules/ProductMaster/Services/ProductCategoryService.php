<?php

namespace Modules\ProductMaster\Services;

use App\Services\NumberSeriesService;
use Modules\ProductMaster\Models\ProductCategory;
use Modules\ProductMaster\Repositories\ProductCategoryRepository;

class ProductCategoryService
{
    public function __construct(
        protected ProductCategoryRepository $categoryRepository,
        protected NumberSeriesService $numberSeriesService,
    ) {}

    public function getAll()
    {
        return $this->categoryRepository->all();
    }

    public function getPaginated(int $perPage = 15)
    {
        return $this->categoryRepository->paginate($perPage);
    }

    public function findById(int $id): ?ProductCategory
    {
        return $this->categoryRepository->find($id);
    }

    public function create(array $data): ProductCategory
    {
        if (!isset($data['category_code'])) {
            $data['category_code'] = $this->numberSeriesService->generateNext('CAT');
        }
        return $this->categoryRepository->create($data);
    }

    public function update(ProductCategory $category, array $data): bool
    {
        return $this->categoryRepository->update($category, $data);
    }

    public function delete(ProductCategory $category): bool
    {
        return $this->categoryRepository->delete($category);
    }

    public function getActiveCategories()
    {
        return $this->categoryRepository->findActive();
    }
}

