  <?php


function registerCommandsAndQueries(\ServiceProvider $sp): void {
    // TODO
}

function registerServices(\ServiceProvider $sp): void {
    // TODO
}

function registerRepositories(\ServiceProvider $sp): void {
    // TODO
}

function registerControllers(\ServiceProvider $sp): void {
    $sp->register(\Presentation\MVC\MVC::class, function () {
        return new \Presentation\MVC\MVC();
    }, isSingleton: true);
    
    $sp->register(\Presentation\Controllers\Home::class);
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
registerRepositories($sp);

// --- Presentation
registerControllers($sp);

// === handle requests
$sp->resolve(\Presentation\MVC\MVC::class)->handleRequest($sp);