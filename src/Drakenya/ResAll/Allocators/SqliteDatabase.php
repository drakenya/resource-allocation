<?php

namespace Drakenya\ResAll\Allocators;

class SqliteDatabase extends AllocatorAbstract {
    /**
     * Generate a new database on disk
     *
     * @return array Details about new resource
     */
    public function allocate() {
        // Allocate new database
        $file_name = tempnam(sys_get_temp_dir(), 'db_');

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
        // Remove the database from the file system
        unlink($data['internal_data']['file_name']);
    }
}