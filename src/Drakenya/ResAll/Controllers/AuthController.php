<?php

namespace Drakenya\ResAll\Controllers;

/**
 * Control all authentication/authorization endpoints
 */
class AuthController extends \Jgut\Slim\Controller\Base {
  /**
   * Show the login form
   * 
   * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
   * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
   * @param  array                                    $args     Args passed in from URL
   * @return \Psr\Http\Message\ResponseInterface                Final PSR7 response
   */
  public function login($request, $response, $args) {
    return $this->view->render($response, 'auth/login.html.twig');
  }

  /**
   * Do the actual login, and procede to site or force back to login page
   * 
   * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
   * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
   * @param  array                                    $args     Args passed in from URL
   * @return \Psr\Http\Message\ResponseInterface                Final PSR7 response
   */
  public function login_action($request, $response, $args) {
    $credentials = [
      'email' => $request->getParsedBody()['email'],
      'password' => $request->getParsedBody()['password'],
    ];

    try {
      $user = $this->sentinel->authenticate($credentials, true);
    }
    catch (Exception $e) {
      return $response->withRedirect($this->router->pathFor('login'));
    }

    if ($user === false) {
      return $response->withRedirect($this->router->pathFor('login'));
    }

    return $response->withRedirect($this->router->pathFor('list-resources'));
  }

  /**
   * Log user out of the system
   * 
   * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
   * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
   * @param  array                                    $args     Args passed in from URL
   * @return \Psr\Http\Message\ResponseInterface                Final PSR7 response
   */
  public function logout($request, $response, $args) {
    $this->sentinel->logout();
    return $response->withRedirect('/');
  }
}
