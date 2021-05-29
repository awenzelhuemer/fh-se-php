  <?php


  function registerCommandsAndQueries(\ServiceProvider $sp): void {
      $sp->register(\Application\Queries\SignedInUserQuery::class);
      $sp->register(\Application\Commands\SignInCommand::class);
      $sp->register(\Application\Commands\SignOutCommand::class);
}

function registerServices(\ServiceProvider $sp): void {
    $sp->register(\Application\Services\AuthenticationService::class);
}

function registerRepositories(\ServiceProvider $sp): void {
    $sp->register(\Infrastructure\FakeRepository::class, isSingleton: true);
    $sp->register(\Application\Interfaces\UserRepository::class, \Infrastructure\FakeRepository::class, isSingleton: true);
}

function registerControllers(\ServiceProvider $sp): void {
    $sp->register(\Presentation\MVC\MVC::class, function () {
        return new \Presentation\MVC\MVC();
    }, isSingleton: true);
    
    $sp->register(\Presentation\Controllers\Home::class);
    $sp->register(\Presentation\Controllers\User::class);
}


spl_autoload_register(function ($class) {
    $file = __DIR__ . '/src/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once($file);
    }
});

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