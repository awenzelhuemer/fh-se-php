<?php

namespace Application\Models;

class RatingData {
    public function __construct(
        private int $id,
        private UserData $user,
        private int $rating,
        private ?string $comment,
        private String $createdDate
    ) { }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return UserData
     */
    public function getUser(): UserData
    {
        return $this->user;
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
     * @return String
     */
    public function getCreatedDate(): String
    {
        return $this->createdDate;
    }


}