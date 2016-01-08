<?php
// Routes

$app->get('/[{name}]', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    return $this->view->render($response, 'index.html.twig', [
        'name' => $args['name']
    ]);
});
