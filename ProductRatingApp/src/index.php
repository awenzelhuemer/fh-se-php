<?php

spl_autoload_register(function ($class) {
    $file = __DIR__ . '/src/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once($file);
    }
});

function registerCommandsAndQueries(\ServiceProvider $sp): void {
      // queries
      $sp->register(\Application\Queries\SignedInUserQuery::class);
      $sp->register(\Application\Queries\ProductsQuery::class);
      $sp->register(\Application\Queries\ProductQuery::class);
      $sp->register(\Application\Queries\ProductDetailQuery::class);

      // commands
      $sp->register(\Application\Commands\AddProductCommand::class);
      $sp->register(\Application\Commands\EditProductCommand::class);
      $sp->register(\Application\Commands\SignInCommand::class);
      $sp->register(\Application\Commands\SignOutCommand::class);
      $sp->register(\Application\Commands\RegisterCommand::class);
      $sp->register(\Application\Commands\AddRatingCommand::class);
      $sp->register(\Application\Commands\RemoveRatingCommand::class);
      $sp->register(\Application\Commands\EditRatingCommand::class);
}

function registerServices(\ServiceProvider $sp): void {
    $sp->register(\Application\Services\AuthenticationService::class);
}

function registerRepositories(\ServiceProvider $sp): void {
    $sp->register(\Infrastructure\FakeRepository::class, isSingleton: true);
    $sp->register(\Infrastructure\Repository::class, function() { return new \Infrastructure\Repository("localhost", "root", "", "productrating");});
    $sp->register(\Application\Interfaces\UserRepository::class, \Infrastructure\Repository::class, isSingleton: true);
    $sp->register(\Application\Interfaces\ProductRepository::class, \Infrastructure\Repository::class, isSingleton: true);
    $sp->register(\Application\Interfaces\RatingRepository::class, \Infrastructure\Repository::class, isSingleton: true);
}

function registerControllers(\ServiceProvider $sp): void {
    $sp->register(\Presentation\MVC\MVC::class, function () {
        return new \Presentation\MVC\MVC();
    }, isSingleton: true);

    $sp->register(\Presentation\Controllers\Error404::class);
    $sp->register(\Presentation\Controllers\Home::class);
    $sp->register(\Presentation\Controllers\User::class);
    $sp->register(\Presentation\Controllers\Products::class);
    $sp->register(\Presentation\Controllers\Ratings::class);
}

// === register services
$sp = new \ServiceProvider();

// --- Application
registerCommandsAndQueries($sp);

// --- Services
registerServices($sp);

// --- Infrastructure
  $sp->register(\Infrastructure\Session::class, isSingleton: true);
  $sp->register(\Application\Interfaces\Session::class, \Infrastructure\Session::class);
registerRepositories($sp);

// --- Presentation
registerControllers($sp);

// === handle requests
$sp->resolve(\Presentation\MVC\MVC::class)->handleRequest($sp);