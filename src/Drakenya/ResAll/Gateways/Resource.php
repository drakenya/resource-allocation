<?php

namespace Drakenya\ResAll\Gateways;

/**
 * Handle all Resource-related queries
 */
class Resource {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Get all resources currently available to request
     *
     * @return array
     */
    public function get_requestable_resources() {
        $sql = 'SELECT id, name
                FROM resource_types
                  LEFT JOIN (SELECT resource_type_id, COUNT(*) AS c
                             FROM resources
                             WHERE is_allocated = 1
                             GROUP BY resource_type_id)
                            resource_join ON (resource_types.id = resource_join.resource_type_id)
                WHERE (resource_types.maximum > resource_join.c OR c IS NULL)
                ORDER BY name';

        $resources = [];
        foreach ($this->pdo->query($sql) as $row) {
            $resources[] = [
                'id' => $row['id'],
                'name' => $row['name'],
            ];
        }

        return $resources;
    }

    /**
     * Generate new database record for a new Resource
     *
     * @param int $resource_type_id
     * @param int $user_id
     * @return int
     */
    public function allocate_resource($resource_type_id, $user_id) {
        $sql = 'INSERT INTO resources (resource_type_id, user_id, internal_key, internal_data, expires_at, is_allocated)
                VALUES (:resource_type_id, :user_id, :internal_key, :internal_data, :expires_at, :is_allocated)';

        $expires_date = (new \DateTime('now'))->modify('+2 hours')->format('Y-m-d H:i:s');
        $data = [
            ':resource_type_id' => $resource_type_id,
            ':user_id' => $user_id,
            ':internal_key' => uniqid(),
            ':internal_data' => null,
            ':expires_at' => $expires_date,
            ':is_allocated' => true,
        ];

        $query = $this->pdo->prepare($sql);
        $query->execute($data);

        return $this->pdo->lastInsertId();
    }

    /**
     * Retrieve the internal class name of a specific resource
     *
     * @param int $resource_id
     * @return string
     */
    public function get_allocator_name($resource_id) {
        $sql = 'SELECT internal_class
                FROM resources
                  JOIN resource_types ON (resources.resource_type_id = resource_types.id)
                WHERE resources.id = :id';
        $data = [
            ':id' => $resource_id,
        ];

        $query = $this->pdo->prepare($sql);
        $query->execute($data);
        $row = $query->fetch();

        return $row['internal_class'];
    }

    /**
     * Set resource-specific data, after it's generated
     *
     * @param int $resource_id
     * @param array $resource_data
     */
    public function set_resource_data($resource_id, $resource_data) {
        $sql = 'UPDATE resources
                SET internal_data = :internal_data
                WHERE id = :id';

        $data = [
            ':id' => $resource_id,
            ':internal_data' => serialize($resource_data),
        ];

        $query = $this->pdo->prepare($sql);
        $query->execute($data);
    }

    /**
     * Get all possible resource data (usually for display purposes)
     *
     * @param int $resource_id
     * @return array
     */
    public function get_resource_details($resource_id) {
        $sql = 'SELECT name, internal_class, internal_key, expires_at, internal_data, expires_at < datetime("now", "localtime") AS is_expired
                FROM resources
                  LEFT JOIN resource_types ON (resources.resource_type_id = resource_types.id)
                WHERE resources.id = :id';

        $data = [
            ':id' => $resource_id,
        ];

        $query = $this->pdo->prepare($sql);
        $query->execute($data);

        $row = $query->fetch();
        $row['internal_data'] = unserialize($row['internal_data']);

        return $row;
    }

    /**
     * Get all resources a user currently has allocated out
     *
     * @param int $user_id
     * @return array
     */
    public function get_user_allocated_resources($user_id) {
        $sql = 'SELECT resources.id AS resource_id, internal_key, expires_at, name
                FROM resources
                  JOIN resource_types ON (resources.resource_type_id = resource_types.id)
                WHERE resources.user_id = :user_id
                  AND expires_at > datetime("now", "localtime")
                  AND is_allocated = :is_allocated
                ORDER BY name, expires_at';

        $data = [
            ':user_id' => $user_id,
            ':is_allocated' => true,
        ];

        $query = $this->pdo->prepare($sql);
        $query->execute($data);

        $rows = $query->fetchAll();
        return $rows;
    }

    /**
     * Deallocate a resource (set expired time to the current time)
     *
     * @param int $resource_id
     * @return array
     */
    public function deallocate_resource_from_user($resource_id) {
        $sql = 'UPDATE resources
                SET is_allocated = :is_allocated
                WHERE id = :id';

        $data = [
            ':id' => $resource_id,
            ':is_allocated' => false,
        ];

        $query = $this->pdo->prepare($sql);
        $query->execute($data);
    }
}