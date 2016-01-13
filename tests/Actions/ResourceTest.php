<?php

namespace tests\Actions;

use Slim\Environment;
use \Mockery as m;

/**
 * Test any uses of the Resource Action
 */
class ResourceActionTest extends \PHPUnit_Framework_TestCase {
    /**
     * Ensure that Mockery cleanup is completed
     */
    public function tearDown() {
        m::close();
    }

    /**
     * Test destroying a resource (that the gateway gets the call to deallocate)
     */
    public function testDestroyResource() {
        $resource_gateway = m::mock('resource_gateway');
        $resource_gateway->shouldReceive('get_allocator_name')->andReturn();
        $resource_gateway->shouldReceive('get_resource_details')->andReturn();
        // This is the main call we care about
        $resource_gateway->shouldReceive('deallocate_resource_from_user')->times(1)->andReturn();

        $allocator = m::mock('allocator');
        $allocator->shouldReceive('deallocate')->andReturn();

        $allocator_factory = m::mock('allocator_factory');
        $allocator_factory->shouldReceive('new_instance')->times(1)->andReturn($allocator);

        $resource_action = new \Drakenya\ResAll\Actions\Resource($resource_gateway, $allocator_factory);
        $resource_action->destroy_resource(1);
    }

    /**
     * Test creating a resource
     */
    public function testCreateResource() {
        $expected_resource_id = rand();
        $resource_gateway = m::mock('resource_gateway');
        $resource_gateway->shouldReceive('get_allocator_name')->andReturn();
        // This is the main call we care about
        $resource_gateway->shouldReceive('allocate_resource')->times(1)->andReturn($expected_resource_id);
        $resource_gateway->shouldReceive('set_resource_data')->times(1)->andReturn();

        $allocator = m::mock('allocator');
        $allocator->shouldReceive('allocate')->times(1)->andReturn();

        $allocator_factory = m::mock('allocator_factory');
        $allocator_factory->shouldReceive('new_instance')->times(1)->andReturn($allocator);

        $resource_action = new \Drakenya\ResAll\Actions\Resource($resource_gateway, $allocator_factory);
        $resource_id = $resource_action->create_resource(1, 1);

        $this->assertEquals($expected_resource_id, $resource_id);
    }
}
