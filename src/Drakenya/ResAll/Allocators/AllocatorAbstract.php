<?php

namespace Drakenya\ResAll\Allocators;

/**
 * Abstract to define constructor actions for all Allocators
 */
abstract class AllocatorAbstract implements AllocatorInterface {
    protected $settings;

    public function __construct($settings) {
        $this->settings = $settings;
    }
}