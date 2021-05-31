<?php

namespace Application\Entities;

class Rating {

    /**
     * Rating constructor.
     */
    public function __construct(
        private int $id,
        private int $userId,
        private int $productId,
        private int $rating,
        private ?string $comment,
        private string $createdDate
    ) { }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->productId;
    }

    /**
     * @return int
     */
    public function getRating(): int
    {
        return $this->rating;
    }

    /**
     * @return string
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * @return string
     */
    public function getCreatedDate(): string
    {
        return $this->createdDate;
    }
}