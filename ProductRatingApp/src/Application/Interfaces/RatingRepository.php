<?php

namespace Application\Interfaces;

interface RatingRepository {

    public function getRatingAverageForProduct(int $productId): float;
    public function getRatingCountForProduct(int $productId): int;
}