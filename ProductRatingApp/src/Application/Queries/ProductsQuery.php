<?php

namespace Application\Queries;

use Application\Interfaces\ProductRepository;
use Application\Interfaces\UserRepository;
use Application\Models\ProductData;
use Application\Models\UserData;

class ProductsQuery
{
    public function __construct(
        private ProductRepository $productRepository,
        private UserRepository $userRepository
    ) {
    }

    public function execute(): array{
        $results = [];

        $products = $this->productRepository->getProducts();

        foreach($products as $product) {

            $user = $this->userRepository->getUser($product->getUserId());

            $results[] = new ProductData(
                $product->getId(),
                $product->getProducer(),
                new UserData($user->getId(), $user->getUserName()),
                $product->getName(),
                0, // TODO get rating
                0 // TODO get rating count
                );
        }

        return $results;
    }
}