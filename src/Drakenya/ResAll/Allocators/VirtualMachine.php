<?php

namespace Drakenya\ResAll\Allocators;

class VirtualMachine implements AllocatorInterface {
    /**
     * Actually create a new resource
     *
     * @return array Details about new resource
     */
    public function allocate() {
        return [];
    }

    /**
     * Remove existing resource from the pool/system
     *
     * @param array $data
     */
    public function deallocate($data) {
    }
}