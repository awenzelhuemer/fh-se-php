<?php

use Infrastructure\Repository;
use Presentation\Bar;

spl_autoload_register(function ($class) {
    $file = __DIR__ . '/src/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once($file);
    }
});

// === register services
$sp = new \ServiceProvider();
// --- Application
$sp->register(\Application\AddBookToCartCommand::class);
$sp->register(\Application\BookSearchQuery::class);
$sp->register(\Application\BooksQuery::class);
$sp->register(\Application\CategoriesQuery::class);
$sp->register(\Application\RemoveBookFromCartCommand::class);
$sp->register(\Application\SignedInUserQuery::class);
$sp->register(\Application\SignInCommand::class);
$sp->register(\Application\SignOutCommand::class);
$sp->register(\Application\CartSizeQuery::class);
$sp->register(\Application\CheckOutCommand::class);
// ------ Services
$sp->register(\Application\Services\AuthenticationService::class);
$sp->register(\Application\Services\CartService::class);
// --- Infrastructure
$sp->register(\Infrastructure\Session::class, isSingleton: true);
$sp->register(\Application\Interfaces\Session::class, \Infrastructure\Session::class);

$sp->register(\Infrastructure\Repository::class, function() { return new Repository("localhost", "root", "", "bookshop");});
$sp->register(\Infrastructure\FakeRepository::class, isSingleton: true);

$sp->register(\Application\Interfaces\BookRepository::class, \Infrastructure\Repository::class, isSingleton: true);
$sp->register(\Application\Interfaces\CategoryRepository::class, \Infrastructure\Repository::class, isSingleton: true);
$sp->register(\Application\Interfaces\UserRepository::class, \Infrastructure\Repository::class, isSingleton: true);
$sp->register(\Application\Interfaces\OrderRepository::class, \Infrastructure\Repository::class, isSingleton: true);
// $sp->register(\Application\Interfaces\BookRepository::class, \Infrastructure\FakeRepository::class, isSingleton: true);
// $sp->register(\Application\Interfaces\CategoryRepository::class, \Infrastructure\FakeRepository::class, isSingleton: true);
// $sp->register(\Application\Interfaces\UserRepository::class, \Infrastructure\FakeRepository::class, isSingleton: true);
// $sp->register(\Application\Interfaces\OrderRepository::class, \Infrastructure\FakeRepository::class, isSingleton: true);
// --- Presentation
$sp->register(\Presentation\MVC\MVC::class, function () {
    return new \Presentation\MVC\MVC();
}, isSingleton: true);
$sp->register(\Presentation\Controllers\Books::class);
$sp->register(\Presentation\Controllers\Cart::class);
$sp->register(\Presentation\Controllers\Home::class);
$sp->register(\Presentation\Controllers\Order::class);
$sp->register(\Presentation\Controllers\User::class);


// === handle requests
$sp->resolve(\Presentation\MVC\MVC::class)->handleRequest($sp);