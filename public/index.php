<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $file = __DIR__ . $_SERVER['REQUEST_URI'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

session_start();

$capsule = new \Illuminate\Database\Capsule\Manager();
$capsule->addConnection([
    'driver' => 'sqlite',
    'database' => __DIR__ . '/../data/database.db',
]);
$capsule->bootEloquent();

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';

// Set up PDO
$container = new \Slim\Container($settings);
$container['pdo'] = function ($container) {
    return new \PDO('sqlite:' . __DIR__ . '/../data/database.db');
};

$container['view'] = function ($c) {
    $view = new \Slim\Views\Twig(__DIR__ . '/../templates');

    $view->addExtension(new Slim\Views\TwigExtension(
        $c['router'],
        $c['request']->getUri()
    ));

    return $view;
};

$app = new \Slim\App($container);

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

// Register routes
require __DIR__ . '/../src/routes.php';

// Run app
$app->run();
