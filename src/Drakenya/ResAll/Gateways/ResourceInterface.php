<?php

namespace Drakenya\ResAll\Gateways;

/**
 * Contract for defining a resource gateway (model)
 */
interface ResourceInterface {
    /**
     * Get all resources currently available to request
     *
     * @return array
     */
    public function get_requestable_resources();

    /**
     * Generate new database record for a new Resource
     *
     * @param int $resource_type_id
     * @param int $user_id
     * @return int
     */
    public function allocate_resource($resource_type_id, $user_id);

    /**
     * Retrieve the internal class name of a specific resource
     *
     * @param int $resource_id
     * @return string
     */
    public function get_allocator_name($resource_id);

    /**
     * Set resource-specific data, after it's generated
     *
     * @param int $resource_id
     * @param array $resource_data
     */
    public function set_resource_data($resource_id, $resource_data);

    /**
     * Get all possible resource data (usually for display purposes)
     *
     * @param int $resource_id
     * @return array
     */
    public function get_resource_details($resource_id);

    /**
     * Get all resources a user currently has allocated out
     *
     * @param int $user_id
     * @return array
     */
    public function get_user_allocated_resources($user_id);

    /**
     * Deallocate a resource (set expired time to the current time)
     *
     * @param int $resource_id
     * @return array
     */
    public function deallocate_resource_from_user($resource_id);

    /**
     * Find all resources currently allocate but that have expired
     *
     * @return array
     */
    public function get_expired_resource_ids();
}