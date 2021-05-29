<?php

namespace Application\Entities;

class Product {

    /**
     * Product constructor.
     * @param int $id
     * @param string $producer
     * @param string $userId
     * @param string $name
     */
    public function __construct(
        private int $id,
        private string $producer,
        private string $userId,
        private string $name)
    { }

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
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}