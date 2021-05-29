<?php

namespace Application\Queries;

use Application\Interfaces\ProductRepository;
use Application\Interfaces\RatingRepository;
use Application\Interfaces\UserRepository;
use Application\Models\ProductDetailData;
use Application\Models\RatingData;
use Application\Models\UserData;

class ProductDetailQuery {

    public function __construct(
        private ProductRepository $productRepository,
        private RatingRepository $ratingRepository,
        private UserRepository $userRepository,
    )
    {
    }

    public function execute(int $id): ?ProductDetailData {
        $product = $this->productRepository->getProduct($id);

        if($product === null) {
            return null;
        }

        $ratingResult = $this->ratingRepository->getRatingsFromProduct($id);
        $userResult = $this->userRepository->getUser($product->getUserId());

        $ratings = [];

        foreach ($ratingResult as $rating) {

            // Load user if necessary
            $ratingUser = $rating->getUserId() !== $userResult->getId() ? $this->userRepository->getUser($product->getUserId()) : $userResult;

            $ratings[] = new RatingData(
                $rating->getId(),
                new UserData($ratingUser->getId(), $ratingUser->getUserName()),
                $rating->getRating(),
                $rating->getComment(),
                $rating->getCreatedDate()
            );
        }

        return new ProductDetailData(
            $product->getId(),
            $product->getProducer(),
            new UserData($userResult->getId(), $userResult->getUserName()),
            $product->getName(),
            $ratings
        );
    }
}