<?php

namespace Infrastructure;

use Application\Entities\Book;
use Application\Entities\Category;
use Application\Entities\User;
use Application\Interfaces\BookRepository;
use Application\Interfaces\CategoryRepository;
use Application\Interfaces\OrderRepository;
use \Application\Interfaces\UserRepository;

class FakeRepository implements
UserRepository
{
    private $mockUsers;

    public function __construct()
    {
        // create mock data
        $this->mockUsers = array(
            array(1, 'scr4', 'scr4')
        );
    }

    public function getUser(int $id): ?User {
        foreach($this->mockUsers as $u) {
            if($u[0] === $id) {
                return new User($u[0], $u[1], $u[2]);
            }
        }
        return null;
    }

    public function getUserForUserNameAndPassword(string $userName, string $password): ?User
    {
        foreach($this->mockUsers as $u) {
            if($u[1] === $userName && $u[2] === $password) {
                return new User($u[0], $u[1], $u[2]);
            }
        }
        return null;
    }
}
