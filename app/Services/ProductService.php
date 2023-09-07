<?php

namespace App\Services;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAll()
    {
        return $this->productRepository->index();
    }
    
    public function findProduct(int $id)
    {
        return $this->productRepository->find($id);
    }

    public function createProduct(array $data)
    {
        return $this->productRepository->create($data);
    }

    public function updateProduct(Product $product, array $data)
    {
        return $this->productRepository->update($product, $data);
    }

    public function deleteProduct(Product $product)
    {
        $this->productRepository->delete($product);
    }
}
