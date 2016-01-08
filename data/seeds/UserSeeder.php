<?php

use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
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
        $capsule = new \Illuminate\Database\Capsule\Manager();
        $capsule->addConnection([
            'driver' => 'sqlite',
            'database' => __DIR__ . '/../../data/database.db',
        ]);
        $capsule->bootEloquent();

        \Cartalyst\Sentinel\Native\Facades\Sentinel::register([
            'email' => 'andrew@example.com',
            'password' => 'password'
        ]);

    }
}
