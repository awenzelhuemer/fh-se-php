<?php

namespace Application\Models;

class ProductData {

    public function __construct(
        private int $id,
        private string $producer,
        private UserData $user,
        private string $name,
        private float $rating,
        private int $ratingCount
    ) { }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getProducer(): string
    {
        return $this->producer;
    }

    /**
     * @return string
     */
    public function getUserName(): ?string
    {
        if($this->user) {
            return $this->user->getUserName();
        } else {
            return null;
        }
    }

    /**
     * @return int
     */
    public function getUserId(): ?int
    {
        if($this->user) {
            return $this->user->getId();
        } else {
            return null;
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getRating(): float
    {
        return $this->rating;
    }

    /**
     * @return int
     */
    public function getRatingCount(): int
    {
        return $this->ratingCount;
    }


}