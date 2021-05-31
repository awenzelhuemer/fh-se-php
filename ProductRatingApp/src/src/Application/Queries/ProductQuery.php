<?php

namespace Application\Queries;

use Application\Interfaces\ProductRepository;
use Application\Interfaces\RatingRepository;
use Application\Interfaces\UserRepository;
use Application\Models\ProductData;
use Application\Models\ProductDetailData;
use Application\Models\RatingData;
use Application\Models\UserData;

class ProductQuery {

    public function __construct(
        private ProductRepository $productRepository,
        private UserRepository $userRepository,
        private RatingRepository $ratingRepository
    )
    {
    }

    public function execute(int $id): ?ProductData {
        $product = $this->productRepository->getProduct($id);

        if($product === null) {
            return null;
        }

        $userResult = $this->userRepository->getUser($product->getUserId());

        return new ProductData(
            $product->getId(),
            $product->getProducer(),
            new UserData($userResult->getId(), $userResult->getUserName()),
            $product->getName(),
            $this->ratingRepository->getRatingAverageForProduct($product->getId()),
            $this->ratingRepository->getRatingCountForProduct($product->getId())
        );
    }
}