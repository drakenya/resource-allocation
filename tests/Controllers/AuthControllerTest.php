<?php

namespace tests\Controllers;

/**
 * Provide basic smoke tests for the Auth Controller
 */
class AuthControllerTest extends ControllerTestBase {
    /**
     * Data provider for basic smoke test, seeing if a route exists
     * @return array
     */
    public function provider_testRouteExists() {
        return [
            ['/auth/login'],
            ['/auth/login-action', 'POST'],
            ['/auth/logout'],
        ];
    }
}
