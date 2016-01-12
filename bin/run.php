<?php

require __DIR__ . '/../vendor/autoload.php';

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

$container->get('environment')['REQUEST_URI'] = $argv[1];
$container->get('environment')['REQUEST_METHOD'] = 'GET';

// Start the app
$app = new \Slim\App($container);

// Set up dependencies
require __DIR__ . '/../lib/dependencies.php';

// Register middleware
require __DIR__ . '/../lib/middleware.php';

// Register routes
require __DIR__ . '/../lib/routes_cli.php';

// Run app
$app->run();
