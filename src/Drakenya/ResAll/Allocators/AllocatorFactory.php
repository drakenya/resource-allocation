<?php

namespace Drakenya\ResAll\Allocators;

/**
 * Factory for generating Allocators
 */
class AllocatorFactory {
    /**
     * Dynamically create an Allocator, based on type
     *
     * @param string $name
     * @return AllocatorInterface
     */
    public function new_instance($name) {
        $name = __NAMESPACE__ . '\\' . $name;
        return new $name();
    }
}