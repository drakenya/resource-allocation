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

$container['TestController'] = function ($container) {
    return new \Drakenya\ResAll\Controllers\TestController($container);
};
