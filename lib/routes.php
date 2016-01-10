<?php
// Routes

$app->group('/auth/', function () {
    $this->get('login', 'AuthController:login')->setName('login');
    $this->post('login-action', 'AuthController:login_action')->setName('login-action');
    $this->get('logout', 'AuthController:logout')->setName('logout');
});

$app->group('/resource/', function () {
    $this->get('list', 'ResourceController:listing')->setName('list-resources');
    $this->get('details/{id}', 'ResourceController:details')->setName('resource-details');
    $this->get('request', 'ResourceController:request')->setName('request-resource');
    $this->post('request-action', 'ResourceController:request_action')->setName('request-resource-action');
})->add(function ($request, $response, $next) {
    // Require user to be logged in to see resource information
    if (!$this->sentinel->check()) {
        return $response->withRedirect('/auth/login');
    }

    $response = $next($request, $response);
    return $response;
});

$app->get('/', 'IndexController:index');
