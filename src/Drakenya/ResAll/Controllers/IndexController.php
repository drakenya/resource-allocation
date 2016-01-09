<?php

namespace Drakenya\ResAll\Controllers;

/**
 * Control static home page
 */
class IndexController extends \Jgut\Slim\Controller\Base {
  /**
   * Display base home page
   * 
   * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
   * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
   * @param  array                                    $args     Args passed in from URL
   * @return \Psr\Http\Message\ResponseInterface                Final PSR7 response
   */
  public function index($request, $response, $args) {
    return $this->view->render($response, 'index.html.twig', [
        'name' => $args['name']
    ]);
  }
}
