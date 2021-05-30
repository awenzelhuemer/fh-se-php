<?php

namespace Infrastructure;

use Application\Entities\Book;
use Application\Entities\Category;
use Application\Entities\Product;
use Application\Entities\Rating;
use Application\Entities\User;
use Application\Interfaces\BookRepository;
use Application\Interfaces\CategoryRepository;
use Application\Interfaces\OrderRepository;
use Application\Interfaces\ProductRepository;
use Application\Interfaces\RatingRepository;
use \Application\Interfaces\UserRepository;

class FakeRepository implements
UserRepository,
    ProductRepository,
    RatingRepository
{
    private $mockUsers;
    private $mockProducts;
    private $mockRatings;

    public function __construct()
    {
        // create mock data
        $this->mockUsers = array(
            array(1, 'scr4', 'scr4')
        );

        $this->mockProducts = array(
            array(1, 'Hilti', 1, 'Schlagbohrmaschine'),
            array(2, 'Bosch', 1, 'Schlagbohrmaschine'),
            array(3, 'Makita', 1, 'Schlagbohrmaschine')
        );

        $this->mockRatings = array(
          array(1, 1, 1, 5, "Hilti quality!", date_format(new \DateTime(),"YYYY/MM/DD H:i:s"))
        );
    }

    public function getUser(int $id): ?User {
        foreach($this->mockUsers as $u) {
            if($u[0] === $id) {
                return new User($u[0], $u[1]);
            }
        }
        return null;
    }

    public function getUserForUserNameAndPassword(string $userName, string $password): ?User
    {
        foreach($this->mockUsers as $u) {
            if($u[1] === $userName && $u[2] === $password) {
                return new User($u[0], $u[1]);
            }
        }
        return null;
    }

    public function getUserForUserName(string $userName): ?\Application\Entities\User
    {
        foreach($this->mockUsers as $u) {
            if($u[1] === $userName) {
                return new User($u[0], $u[1]);
            }
        }
        return null;
    }

    public function createUser(string $userName, string $password) : int
    {
        $count = sizeof($this->mockUsers);
        $newId = 0;
        if($count > 0) {
            $user = $this->mockUsers[$count - 1];
            $newId = $user[0];
            $newId++;
        }

        array_push($this->mockUsers,
            array($newId, $userName, $password)
        );

        return $newId;
    }

    public function getProducts(): array
    {
        $result = [];
        foreach($this->mockProducts as $product) {
            $result[] = new Product($product[0], $product[1], $product[2], $product[3]);
        }

        return $result;
    }

    public function getRatingAverageForProduct(int $productId): float
    {
        $ratingSum = 0;
        $ratingCount = 0;
        foreach ($this->mockRatings as $rating) {
            if($rating[3] === $productId) {
                $ratingCount++;
                $ratingSum += $rating[2];
            }
        }
        return $ratingCount / $ratingSum;
    }

    public function getRatingCountForProduct(int $productId): int
    {
        $ratingCount = 0;
        foreach ($this->mockRatings as $rating) {
            if($rating[2] === $productId) {
                $ratingCount++;
            }
        }
        return $ratingCount;
    }

    public function getProduct(int $id) : ?Product
    {
        foreach ($this->mockProducts as $product) {
            if($product[0] === $id) {
                return new Product($product[0], $product[1], $product[2], $product[3]);
            }
        }
        return null;
    }

    public function getRatingsFromProduct(int $productId): array
    {
        $result = [];
        foreach($this->mockRatings as $rating) {
            if($rating[2] === $productId) {
                $result[] = new Rating($rating[0], $rating[1], $rating[2], $rating[3], $rating[4], $rating[5]);
            }
        }

        return $result;
    }

    public function addRating(int $userId, int $productId, int $rating, ?string $comment): ?int
    {
        $count = sizeof($this->mockUsers);
        $newId = 0;
        if($count > 0) {
            $user = $this->mockUsers[$count - 1];
            $newId = $user[0];
            $newId++;
        }

        $this->mockRatings[] = new Rating(
            $newId,
            $userId,
            $productId,
            $rating,
            $comment,
            date_format(new \DateTime(),"YYYY/MM/DD H:i:s")
        );

        return $newId;
    }

    public function editRating(int $id, ?int $userId, int $productId, int $rating, ?string $comment): void
    {
        for ($i = 0; $i < sizeof($this->mockRatings); $i++) {
            if ($this->mockRatings[$i][0] === $id) {
                $result[$i] = new Rating($id, $userId, $productId, $comment, $rating, $this->mockRatings[$i][5]);
            }
        }
    }

    public function canEditRating(int $id, int $userId): bool
    {
        foreach($this->mockRatings as $rating) {
            if($rating[0] === $id && $rating[1] == $userId) {
                return true;
            }
        }
        return false;
    }

    public function removeRating(int $id): void
    {
        for ($i = 0; $i < sizeof($this->mockRatings); $i++) {
            if($this->mockRatings[$i][0] === $id) {
                unset($this->mockRatings[$i]);
            }
        }
    }
}
