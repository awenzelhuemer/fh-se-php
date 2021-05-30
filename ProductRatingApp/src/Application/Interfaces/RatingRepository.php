<?php

namespace Application\Interfaces;

interface RatingRepository {

    public function getRatingAverageForProduct(int $productId): float;
    public function getRatingCountForProduct(int $productId): int;
    public function getRatingsFromProduct(int $productId): array;
    public function addRating(int $userId, int $productId, int $rating, ?string $comment): ?int;
    public function editRating(int $id, ?int $userId, int $productId, int $rating, ?string $comment): void;
    public function removeRating(int $id);
    public function canEditRating(int $id, int $userId): bool;
}