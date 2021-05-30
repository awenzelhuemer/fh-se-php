<?php

namespace Infrastructure;

use Application\Entities\Product;
use Application\Entities\Rating;

class Repository
    implements
    \Application\Interfaces\UserRepository,
    \Application\Interfaces\ProductRepository,
    \Application\Interfaces\RatingRepository
{

    private $server;
    private $userName;
    private $password;
    private $database;

    public function __construct(string $server, string $userName, string $password, string $database)
    {
        $this->server = $server;
        $this->userName = $userName;
        $this->password = $password;
        $this->database = $database;
    }

    // === private helper methods ===

    private function getConnection()
    {
        $con = new \mysqli($this->server, $this->userName, $this->password, $this->database);
        if (!$con) {
            die('Unable to connect to database. Error: ' . mysqli_connect_error());
        }
        return $con;
    }

    private function executeQuery($connection, $query)
    {
        $result = $connection->query($query);
        if (!$result) {
            die("Error in query '$query': " . $connection->error);
        }
        return $result;
    }

    private function executeStatement($connection, $query, $bindFunc)
    {
        $statement = $connection->prepare($query);
        if (!$statement) {
            die("Error in prepared statement '$query': " . $connection->error);
        }
        $bindFunc($statement);
        if (!$statement->execute()) {
            die("Error executing prepared statement '$query': " . $statement->error);
        }
        return $statement;
    }

    // === public methods ===

    public function getUserForUserName(string $userName): ?\Application\Entities\User
    {
        $user = null;
        $con = $this->getConnection();
        $stat = $this->executeStatement(
            $con,
            'SELECT id, passwordHash FROM users WHERE userName = ?',
            function ($s) use ($userName) {
                $s->bind_param('s', $userName);
            }
        );
        $stat->bind_result($id, $passwordHash);
        if ($stat->fetch()) {
            $user = new \Application\Entities\User($id, $userName, $passwordHash);
        }
        $stat->close();
        $con->close();
        return $user;
    }

    public function getUserForUserNameAndPassword(string $userName, string $password): ?\Application\Entities\User
    {
        $user = null;
        $con = $this->getConnection();
        $stat = $this->executeStatement(
            $con,
            'SELECT id, passwordHash FROM users WHERE userName = ?',
            function ($s) use ($userName) {
                $s->bind_param('s', $userName);
            }
        );
        $stat->bind_result($id, $passwordHash);
        if ($stat->fetch() && password_verify($password, $passwordHash)) {
            $user = new \Application\Entities\User($id, $userName);
        }
        $stat->close();
        $con->close();
        return $user;
    }

    public function getUser(int $id): ?\Application\Entities\User
    {
        $user = null;
        $con = $this->getConnection();
        $stat = $this->executeStatement(
            $con,
            'SELECT id, userName FROM users WHERE id = ?',
            function ($s) use ($id) {
                $s->bind_param('i', $id);
            }
        );
        $stat->bind_result($id, $userName);
        if ($stat->fetch()) {
            $user = new \Application\Entities\User($id, $userName);
        }
        $stat->close();
        $con->close();
        return $user;
    }

    public function createUser(string $userName, string $password): int
    {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $con = $this->getConnection();
        $con->autocommit(false);
        $stat = $this->executeStatement(
            $con,
            'INSERT INTO users (userName, passwordHash) VALUES (?, ?)',
            function ($s) use ($userName, $password) {
                $s->bind_param('ss', $userName, $password);
            }
        );
        $userId = $stat->insert_id;
        $stat->close();
        $con->commit();
        $con->close();
        return $userId;
    }

    public function getProducts(): array
    {
        $products = [];
        $con = $this->getConnection();
        $result = $this->executeQuery(
            $con,
            'SELECT id, producer, userId, name FROM products'
        );
        while ($product = $result->fetch_object()) {
            $products[] = new \Application\Entities\Product($product->id, $product->producer, $product->userId, $product->name);
        }
        $result->close();
        $con->close();
        return $products;
    }

    public function getRatingAverageForProduct(int $productId): float
    {
        $con = $this->getConnection();
        $stat = $this->executeStatement(
            $con,
            'SELECT AVG(rating) as averageRating FROM `ratings` WHERE productId = ?',
            function($s) use ($productId) {
                $s->bind_param('i', $productId);
            }
        );

        $stat->bind_result($averageRating);
        $stat->fetch();

        $stat->close();
        $con->close();

        return round($averageRating, 2);
    }

    public function getRatingCountForProduct(int $productId): int
    {
        $con = $this->getConnection();
        $stat = $this->executeStatement(
            $con,
            'SELECT COUNT(ID) as count FROM `ratings` WHERE productId = ?',
            function($s) use ($productId) {
                $s->bind_param('i', $productId);
            }
        );

        $stat->bind_result($count);
        $stat->fetch();

        $stat->close();
        $con->close();

        return $count;
    }

    public function getProduct(int $id): ?Product
    {
        $product = null;
        $con = $this->getConnection();
        $stat = $this->executeStatement(
            $con,
            'SELECT id, producer, userId, name FROM `products` WHERE id = ?',
            function($s) use ($id) {
                $s->bind_param('i', $id);
            }
        );

        $stat->bind_result($id, $producer, $userId, $name);
        if ($stat->fetch()) {
            $product = new \Application\Entities\Product($id, $producer, $userId, $name);
        }

        $stat->close();
        $con->close();

        return $product;
    }

    public function getRatingsFromProduct(int $productId): array
    {
        $ratings = [];
        $con = $this->getConnection();
        $stat = $this->executeStatement(
            $con,
            'SELECT id, userId, productId, rating, comment, createdDate FROM `ratings` WHERE productId = ? ORDER BY createdDate DESC',
            function($s) use ($productId) {
                $s->bind_param('i', $productId);
            }
        );

        $stat->bind_result($id, $userId, $productId, $rating, $comment, $createdDate);
        while ($stat->fetch()) {
            $ratings[] = new Rating($id, $userId, $productId, $rating, $comment, $createdDate);
        }

        $stat->close();
        $con->close();

        return $ratings;
    }

    public function addRating(int $userId, int $productId, int $rating, ?string $comment): ?int
    {
        $con = $this->getConnection();
        $stat = $this->executeStatement(
            $con,
            'INSERT INTO `ratings` (`userId`, `productId`, `rating`, `comment`, `createdDate`) VALUES (?, ?, ?, ?, NOW())',
            function($s) use ($userId, $productId, $rating, $comment) {
                $s->bind_param('iiis', $userId, $productId, $rating, $comment);
            }
        );

        $newRatingId = $stat->insert_id;
        $stat->close();
        $con->close();

        return $newRatingId;
    }

    public function editRating(int $id, ?int $userId, int $productId, int $rating, ?string $comment): void
    {
        $con = $this->getConnection();
        $stat = $this->executeStatement(
            $con,
            'UPDATE ratings SET userId = ?, productId = ?, rating = ?, comment = ? WHERE id = ?',
            function($s) use ($id, $userId, $productId, $rating, $comment) {
                $s->bind_param('iiisi', $userId, $productId, $rating, $comment, $id);
            }
        );
        $stat->close();
        $con->close();
    }

    public function canEditRating(int $id, int $userId): bool
    {
        $con = $this->getConnection();
        $stat = $this->executeStatement(
            $con,
            'SELECT COUNT(rating) as count FROM `ratings` WHERE id = ? && userId = ?',
            function($s) use ($id, $userId) {
                $s->bind_param('ii', $id, $userId);
            }
        );

        $stat->bind_result($count);
        $stat->fetch();

        $stat->close();
        $con->close();

        return $count == 1;
    }

    public function removeRating(int $id)
    {
        $con = $this->getConnection();
        $stat = $this->executeStatement(
            $con,
            'DELETE FROM ratings WHERE id = ?',
            function($s) use ($id) {
                $s->bind_param('i', $id);
            }
        );
        $stat->close();
        $con->close();
    }
}