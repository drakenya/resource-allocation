<?php

use Phinx\Migration\AbstractMigration;

class CreateUserMigration extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $this->table('activations')
            ->addColumn('user_id', 'integer')
            ->addColumn('code', 'string')
            ->addColumn('completed', 'boolean', ['default' => false])
            ->addColumn('completed_at', 'datetime')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->create();

        $this->table('persistences')
            ->addColumn('user_id', 'integer')
            ->addColumn('code', 'string')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->create();

        $this->table('reminders')
            ->addColumn('user_id', 'integer')
            ->addColumn('code', 'string')
            ->addColumn('completed', 'boolean', ['default' => false])
            ->addColumn('completed_at', 'datetime')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->create();

        $this->table('roles')
            ->addColumn('slug', 'string')
            ->addColumn('name', 'string')
            ->addColumn('permissions', 'string')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->create();

        $this->table('role_users')
            ->addColumn('user_id', 'integer')
            ->addColumn('role_id', 'integer')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->create();

        $this->table('throttle')
            ->addColumn('user_id', 'integer')
            ->addColumn('type', 'string')
            ->addColumn('ip', 'string')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->create();

        $this->table('users')
            ->addColumn('email', 'string')
            ->addColumn('password', 'string')
            ->addColumn('permissions', 'string')
            ->addColumn('last_login', 'datetime')
            ->addColumn('first_name', 'string')
            ->addColumn('last_name', 'string')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->create();
    }
}
