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
$settings = require __DIR__ . '/../lib/settings.php';

// Set up containers
$container = new \Slim\Container($settings);
require __DIR__ . '/../lib/containers.php';

// Start the app
$app = new \Slim\App($container);

// Set up dependencies
require __DIR__ . '/../lib/dependencies.php';

// Register middleware
require __DIR__ . '/../lib/middleware.php';

// Register routes
require __DIR__ . '/../lib/routes.php';

// Run app
$app->run();
