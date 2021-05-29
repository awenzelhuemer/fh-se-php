<?php

namespace Application\Interfaces;

use Application\Entities\Product;

interface ProductRepository
{
    public function getProduct(int $id): ?Product;
    public function getProducts(): array;
}