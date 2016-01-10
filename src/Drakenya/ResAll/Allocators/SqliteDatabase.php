<?php

namespace Drakenya\ResAll\Allocators;

class SqliteDatabase implements AllocatorInterface {
    /**
     * Generate a new database on disk
     *
     * @return array Details about new resource
     */
    public function allocate() {
        $file_name = tempnam('/tmp', 'db_') . '.db';

        $data = [
            'file_name' => $file_name,
        ];

        return $data;
    }

    /**
     * Remove database from disk
     *
     * @param array $data
     */
    public function deallocate($data) {

    }
}