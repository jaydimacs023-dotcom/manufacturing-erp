<?php

namespace Modules\ProductMaster\Services;

use Modules\ProductMaster\Models\Product;
use Modules\ProductMaster\Models\ProductSpecification;
use Modules\ProductMaster\Repositories\ProductSpecificationRepository;

class ProductSpecificationService
{
    public function __construct(
        protected ProductSpecificationRepository $specificationRepository,
    ) {}

    public function getByProduct(int $productId)
    {
        return $this->specificationRepository->findByProduct($productId);
    }

    public function findById(int $id): ?ProductSpecification
    {
        return $this->specificationRepository->find($id);
    }

    public function create(Product $product, array $data): ProductSpecification
    {
        $data['product_id'] = $product->id;
        return $this->specificationRepository->create($data);
    }

    public function update(ProductSpecification $spec, array $data): bool
    {
        return $this->specificationRepository->update($spec, $data);
    }

    public function delete(ProductSpecification $spec): bool
    {
        return $this->specificationRepository->delete($spec);
    }
}

