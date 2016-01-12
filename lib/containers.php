<?php

// Set up PDO (database connection)
$container['pdo'] = function ($container) {
    return new \PDO('sqlite:' . __DIR__ . '/../data/database.db');
};

// Set up Slim (templating)
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig($container->settings['renderer']['template_path']);

    $view->addExtension(new Slim\Views\TwigExtension(
        $container['router'],
        $container['request']->getUri()
    ));

    return $view;
};

// Set up Gateways (query class)
$container['resource_gateway'] = function ($container) {
    $pdo = $container['pdo'];
    return new \Drakenya\ResAll\Gateways\ResourcePdoSqlite($pdo);
};

// Set up Factories
$container['allocator_factory'] = function ($container) {
    return new \Drakenya\ResAll\Allocators\AllocatorFactory($container->settings['allocator_settings']);
};

// Set up Actions (general-purpose logic containers
$container['resource_action'] = function ($container) {
    return new \Drakenya\ResAll\Actions\Resource(
        $container['resource_gateway'],
        $container['allocator_factory']
    );
};

// Set up Controllers
$container['IndexController'] = function ($container) {
    return new \Drakenya\ResAll\Controllers\IndexController($container);
};
$container['AuthController'] = function ($container) {
    return new \Drakenya\ResAll\Controllers\AuthController($container);
};
$container['ResourceController'] = function ($container) {
    return new \Drakenya\ResAll\Controllers\ResourceController($container);
};
$container['CliController'] = function ($container) {
    return new \Drakenya\ResAll\Controllers\CliController($container);
};

// Set up Sentinel (user authentication library)
$container['sentinel'] = function ($container) {
    $bootstrapper = new Cartalyst\Sentinel\Native\SentinelBootstrapper;
    return $bootstrapper->createSentinel();
};
$container['current_user'] = function ($container) {
    return $container['sentinel']->getUser();
};
