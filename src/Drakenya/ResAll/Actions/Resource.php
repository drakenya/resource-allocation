<?php

namespace Drakenya\ResAll\Actions;

/**
 * Handle common tasks related to resources
 */
class Resource {
    /**
     * @var \Drakenya\ResAll\Gateways\ResourceInterface
     */
    protected $resource_gateway;

    /**
     * @var \Drakenya\ResAll\Allocators\AllocatorFactory
     */
    protected $allocator_factory;

    public function __construct($resource_gateway, $allocator_factory) {
        $this->resource_gateway = $resource_gateway;
        $this->allocator_factory = $allocator_factory;
    }

    /**
     * Destroy/teardown any resource, and remove it from the user
     *
     * @param int $resource_id
     */
    public function destroy_resource($resource_id) {
        $allocator_name = $this->resource_gateway->get_allocator_name($resource_id);
        $allocator = $this->allocator_factory->new_instance($allocator_name);

        $resource_details = $this->resource_gateway->get_resource_details($resource_id);

        $allocator->deallocate($resource_details);
        $this->resource_gateway->deallocate_resource_from_user($resource_id);
    }

    /**
     * Create the resource, allocate to the user, and return the ID of the newly allocated resource
     *
     * @param int $user_id
     * @param int $resource_type_id
     * @return int
     */
    public function create_resource($user_id, $resource_type_id) {
        $resource_id = $this->resource_gateway->allocate_resource($resource_type_id, $user_id);

        $allocator_name = $this->resource_gateway->get_allocator_name($resource_id);
        $allocator = $this->allocator_factory->new_instance($allocator_name);

        $resource_data = $allocator->allocate();
        $this->resource_gateway->set_resource_data($resource_id, $resource_data);

        return $resource_id;
    }
}