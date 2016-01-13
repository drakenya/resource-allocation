<?php

namespace tests\Controllers;

/**
 * Provide basic smoke tests for the Index Controller
 */
class IndexControllerTest extends ControllerTestBase {
    /**
     * Data provider for basic smoke test, seeing if a route exists
     * @return array
     */
    public function provider_testRouteExists() {
        return [
            ['/'],
        ];
    }
}
