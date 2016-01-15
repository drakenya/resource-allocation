<?php

namespace Drakenya\ResAll\Allocators;

class MysqlDatabase extends AllocatorAbstract {
    /**
     * Actually create a new resource
     *
     * @return array Details about new resource
     */
    public function allocate() {
        $pdo = $this->get_pdo();

        // Set up new connection information
        $new_database = uniqid('db_');
        $new_user = substr(uniqid('user_'), 0, 16);
        $new_password = uniqid();

        $sql_queries = [
            "CREATE DATABASE " . $new_database,
            "CREATE USER '" . $new_user . "' IDENTIFIED BY '" . $new_password . "'",
            "GRANT ALL ON `" . $new_database . "`.* TO '" . $new_user . "'",
            "FLUSH PRIVILEGES",
        ];

        foreach ($sql_queries as $sql) {
            $pdo->exec($sql);
        }

        return [
            'database' => $new_database,
            'user' => $new_user,
            'password' => $new_password,
        ];
    }

    /**
     * Remove existing resource from the pool/system
     *
     * @param array $data
     */
    public function deallocate($data) {
        $pdo = $this->get_pdo();

        $old_database = $data['internal_data']['database'];
        $old_user = $data['internal_data']['user'];

        $sql_queries = [
            "DROP DATABASE `" . $old_database . "`",
            "DROP USER '" . $old_user . "'",
        ];

        foreach ($sql_queries as $sql) {
            $pdo->exec($sql);
        }
    }

    /**
     * Get a lcoal MySQL PDO connection, with root-level access
     *
     * @return \PDO
     */
    protected function get_pdo() {
        $dsn = 'mysql:host=' . $this->settings['host'];
        $pdo = new \PDO($dsn, $this->settings['user'], $this->settings['password']);

        return $pdo;
    }
}