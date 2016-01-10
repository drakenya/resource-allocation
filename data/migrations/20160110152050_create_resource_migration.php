<?php

use Phinx\Migration\AbstractMigration;

class CreateResourceMigration extends AbstractMigration
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
        $this->table('resource_types')
            ->addColumn('name', 'string')
            ->addColumn('maximum', 'integer')
            ->addColumn('internal_class', 'string')
            ->create();

        $this->table('resources')
            ->addColumn('resource_type_id', 'integer')
            ->addColumn('user_id', 'integer')
            ->addColumn('internal_key', 'string')
            ->addColumn('internal_data', 'string')
            ->addColumn('expires_at', 'datetime')
            ->create();
    }
}
