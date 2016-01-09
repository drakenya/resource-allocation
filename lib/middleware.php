<?php

use \Slim\Middleware\HttpBasicAuthentication\PdoAuthenticator;

// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);
$app->add(new \Slim\Middleware\HttpBasicAuthentication([
    'path' => '/admin',
    'realm' => 'Protected',
    'authenticator' => new PdoAuthenticator([
        'pdo' => $container['pdo'],
    ])
]));
