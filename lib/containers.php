<?php

$container['pdo'] = function ($container) {
    return new \PDO('sqlite:' . __DIR__ . '/../data/database.db');
};

$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(__DIR__ . '/../templates');

    $view->addExtension(new Slim\Views\TwigExtension(
        $container['router'],
        $container['request']->getUri()
    ));

    return $view;
};

$container['IndexController'] = function ($container) {
    return new \Drakenya\ResAll\Controllers\IndexController($container);
};
$container['AuthController'] = function ($container) {
    return new \Drakenya\ResAll\Controllers\AuthController($container);
};
$container['ResourceController'] = function ($container) {
    return new \Drakenya\ResAll\Controllers\ResourceController($container);
};

$container['sentinel'] = function ($container) {
    $bootstrapper = new Cartalyst\Sentinel\Native\SentinelBootstrapper;
    return $bootstrapper->createSentinel();
};
