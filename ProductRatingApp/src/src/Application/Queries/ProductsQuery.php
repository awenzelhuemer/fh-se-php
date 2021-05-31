<?php

namespace Application\Queries;

use Application\Interfaces\ProductRepository;
use Application\Interfaces\RatingRepository;
use Application\Interfaces\UserRepository;
use Application\Models\ProductData;
use Application\Models\UserData;

class ProductsQuery
{
    public function __construct(
        private ProductRepository $productRepository,
        private UserRepository $userRepository,
        private RatingRepository $ratingRepository
    ) {
    }

    public function execute(?string $filter): array{
        $results = [];

        $products = $filter === null || $filter == "" ? $this->productRepository->getProducts() : $this->productRepository->getProductsForFilter($filter);

        foreach($products as $product) {

            $user = $this->userRepository->getUser($product->getUserId());
            $averageRating = $this->ratingRepository->getRatingAverageForProduct($product->getId());
            $totalCount = $this->ratingRepository->getRatingCountForProduct($product->getId());

            $results[] = new ProductData(
                $product->getId(),
                $product->getProducer(),
                new UserData($user->getId(), $user->getUserName()),
                $product->getName(),
                $averageRating,
                $totalCount
                );
        }

        return $results;
    }
}