<?php

namespace Application\Interfaces;

use Application\Entities\Product;

interface ProductRepository
{
    public function getProduct(int $id): ?Product;
    public function getProducts(): array;
    public function getProductsForFilter(string $filter): array;
    public function addProduct(string $producer, int $userId, string $name): ?int;
    public function canEditProduct(int $id, int $userId): bool;
    public function editProduct(int $id, string $producer, string $name);
}