<?php

namespace Drakenya\ResAll\Controllers;

class TestController extends \Jgut\Slim\Controller\Base {
  public function index($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    return $this->view->render($response, 'index.html.twig', [
        'name' => $args['name']
    ]);
  }
}
