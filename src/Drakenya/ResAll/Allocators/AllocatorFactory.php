<?php

namespace Drakenya\ResAll\Allocators;

/**
 * Factory for generating Allocators
 */
class AllocatorFactory {
    private $settings;

    public function __construct($settings) {
        $this->settings = $settings;
    }

    /**
     * Dynamically create an Allocator, based on type
     *
     * @param string $name
     * @return AllocatorInterface
     */
    public function new_instance($name) {
        $settings = [];
        if (isset($this->settings[$name])) {
            $settings = $this->settings[$name];
        }

        $name = __NAMESPACE__ . '\\' . $name;
        return new $name($settings);
    }
}