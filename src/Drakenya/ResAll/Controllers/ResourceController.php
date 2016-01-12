<?php

namespace Drakenya\ResAll\Controllers;

/**
 * Control resource listing, allocation
 */
class ResourceController extends \Jgut\Slim\Controller\Base {
    /**
     * List a user's current allocated resources
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  array                                    $args     Args passed in from URL
     * @return \Psr\Http\Message\ResponseInterface                Final PSR7 response
     */
    public function listing($request, $response, $args) {
        $user_id = $this->current_user->id;
        $allocated_resources = $this->resource_gateway->get_user_allocated_resources($user_id);

        return $this->view->render($response, 'resource/list.html.twig', [
            'allocated_resources' => $allocated_resources,
        ]);
    }

    /**
     * Show page for a user to request a new resource
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  array                                    $args     Args passed in from URL
     * @return \Psr\Http\Message\ResponseInterface                Final PSR7 response
     */
    public function request($request, $response, $args) {
        $available_resources = $this->resource_gateway->get_requestable_resources();

        return $this->view->render($response, 'resource/request.html.twig', [
            'available_resources' => $available_resources,
        ]);
    }

    /**
     * Handle user requesting a new resource
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  array                                    $args     Args passed in from URL
     * @return \Psr\Http\Message\ResponseInterface                Final PSR7 response
     */
    public function request_action($request, $response, $args) {
        // Save new request to the database
        $user_id = $this->current_user->id;
        $resource_type_id = $request->getParsedBody()['request_type'];
        $resource_id = $this->resource_action->create_resource($user_id, $resource_type_id);

        return $response->withRedirect($this->router->pathFor('resource-details', ['id' => $resource_id]));
    }

    /**
     * Show a user's resource
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  array                                    $args     Args passed in from URL
     * @return \Psr\Http\Message\ResponseInterface                Final PSR7 response
     */
    public function details($request, $response, $args) {
        $resource_id = $args['id'];
        $resource_details = $this->resource_gateway->get_resource_details($resource_id);

        return $this->view->render($response, 'resource/details.html.twig', [
            'id' => $resource_id,
            'resource_details' => $resource_details,
        ]);
    }

    /**
     * Deallocate a user's current resource
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  array                                    $args     Args passed in from URL
     * @return \Psr\Http\Message\ResponseInterface                Final PSR7 response
     */
    public function deallocate_action($request, $response, $args) {
        $resource_id = $request->getParsedBody()['resource_id'];
        $this->resource_action->destroy_resource($resource_id);

        return $response->withRedirect($this->router->pathFor('list-resources'));
    }
}
