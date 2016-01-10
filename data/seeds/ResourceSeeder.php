<?php

use Phinx\Seed\AbstractSeed;
use Illuminate\Support;

class ResourceSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $data = [
            [
                'name' => 'SQLite Database',
                'maximum' => 5,
                'internal_class' => 'SqliteDatabase',
            ],
            [
                'name' => 'MySQL Database',
                'maximum' => 5,
                'internal_class' => 'MysqlDatabase',
            ],
            [
                'name' => 'Virtual Machine',
                'maximum' => 5,
                'internal_class' => 'VirtualMachine',
            ],
        ];

        $this->table('resource_types')
            ->insert($data)
            ->save();
    }
}
