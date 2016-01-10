<?php

namespace Drakenya\ResAll\Allocators;

/**
 * Contract for Allocators
 */
interface AllocatorInterface {
    /**
     * Actually create a new resource
     *
     * @return array Details about new resource
     */
    public function allocate();

    /**
     * Remove existing resource from the pool/system
     *
     * @param array $data
     */
    public function deallocate($data);
}