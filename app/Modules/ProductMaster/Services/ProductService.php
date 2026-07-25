<?php

namespace Modules\ProductMaster\Services;

use App\Services\NumberSeriesService;
use Modules\ProductMaster\Models\Product;
use Modules\ProductMaster\Repositories\ProductRepository;

class ProductService
{
    public function __construct(
        protected ProductRepository $productRepository,
        protected NumberSeriesService $numberSeriesService,
    ) {}

    public function getAll()
    {
        return $this->productRepository->all();
    }

    public function getPaginated(int $perPage = 15)
    {
        return $this->productRepository->paginate($perPage);
    }

    public function findById(int $id): ?Product
    {
        return $this->productRepository->find($id);
    }

    public function create(array $data): Product
    {
        if (!isset($data['product_code'])) {
            $data['product_code'] = $this->numberSeriesService->generateNext('PRD');
        }
        return $this->productRepository->create($data);
    }

    public function update(Product $product, array $data): bool
    {
        return $this->productRepository->update($product, $data);
    }

    public function delete(Product $product): bool
    {
        return $this->productRepository->delete($product);
    }

    public function getActiveProducts()
    {
        return $this->productRepository->findActive();
    }

    public function getByType(string $type)
    {
        return $this->productRepository->findByType($type);
    }
}

