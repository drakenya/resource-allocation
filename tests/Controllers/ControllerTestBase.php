<?php

namespace tests\Controllers;

use \Mockery as m;

class ControllerTestBase extends \PHPUnit_Framework_TestCase {
    /**
     * Handle a call to the app
     * 
     * @param  string $method  GET/POST
     * @param  string $path    URI
     * @param  array  $options
     */
    public function request($method, $path, $options = []) {
        ob_start();

        $settings = require __DIR__ . '/../../lib/settings.php';

        $container = new \Slim\Container($settings);
        require __DIR__ . '/../../lib/containers.php';
        $container->get('environment')['REQUEST_URI'] = $path;
        $container->get('environment')['REQUEST_METHOD'] = $method;

        // Set up custom 404 so that we can easilly check if the page wasn't found
        $container['notFoundHandler'] = function($container) {
            return function ($request, $response) use ($container) {
                return $container['response']
                ->withStatus(404)
                ->withHeader('Content-Type', 'text/plain')
                ->write('Page not found');
            };
        };

        $sentinel = m::mock('sentinel');
        $container['sentinel'] = function ($container) use ($sentinel) {
            return $sentinel;
        };

        $app = new \Slim\App($container);

        // Set up dependencies
        require __DIR__ . '/../../lib/dependencies.php';
        
        // Register middleware
        require __DIR__ . '/../../lib/middleware.php';

        // Register routes
        require __DIR__ . '/../../lib/routes.php';

        
        $app->run();
        $this->app = $app;
        $this->request = $app->getContainer()->request;
        $this->response = $app->getContainer()->response;

        $this->page = ob_get_clean();
    }

    /**
     * @dataProvider provider_testRouteExists
     */
    public function testRouteExists($route, $method = 'GET') {
        $this->request($method, $route);
        $this->assertNotEquals('Page not found', $this->page);
        $this->assertNotContains('Method not allowed.', $this->page);
    }
}
