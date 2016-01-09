<?php
// Routes

$app->group('/auth/', function () {
    $this->get('login', 'AuthController:login')->setName('login');
    $this->post('login-action', 'AuthController:login_action')->setName('login-action');
    $this->get('logout', 'AuthController:logout')->setName('logout');
});

$app->group('/resource/', function () {
    $this->get('list', 'ResourceController:listing')->setName('list-resources');
})->add(function ($request, $response, $next) {
  if (!$this->sentinel->check()) {
    return $response->withRedirect('/auth/login');
  }

  $response = $next($request, $response);
  return $response;
});

$app->get('/', 'IndexController:index');
