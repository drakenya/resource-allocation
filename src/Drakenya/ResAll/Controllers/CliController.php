<?php

namespace Drakenya\ResAll\Controllers;

/**
 * Commands for the command line interface
 */
class CliController extends \Jgut\Slim\Controller\Base {
    /**
     * Remove all outstanding resources assigned to a user that are expired
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  array                                    $args     Args passed in from URL
     * @return \Psr\Http\Message\ResponseInterface                Final PSR7 response
     */
    public function clean($request, $response, $args) {
        $expired_resource_ids = $this->resource_gateway->get_expired_resource_ids();

        foreach ($expired_resource_ids as $resource_id) {
            $this->resource_action->destroy_resource($resource_id);
        }
    }
}
