<?php

namespace Infrastructure;

use Application\Entities\Book;
use Application\Entities\Category;
use Application\Entities\Product;
use Application\Entities\User;
use Application\Interfaces\BookRepository;
use Application\Interfaces\CategoryRepository;
use Application\Interfaces\OrderRepository;
use Application\Interfaces\ProductRepository;
use \Application\Interfaces\UserRepository;

class FakeRepository implements
UserRepository, ProductRepository
{
    private $mockUsers;
    private $mockProducts;

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
}
