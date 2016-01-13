<?php

namespace tests\Controllers;

/**
 * Provide basic smoke tests for the Resource Controller
 */
class ResourceControllerTest extends ControllerTestBase {
    /**
     * Data provider for basic smoke test, seeing if a route exists
     * @return array
     */
    public function provider_testRouteExists() {
        return [
            ['/resource/list'],
            ['/resource/details/1'],
            ['/resource/request'],
            ['/resource/request-action', 'POST'],
            ['/resource/deallocate-action', 'POST'],
        ];
    }
}
