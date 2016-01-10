<?php
return [
    'settings' => [
        'displayErrorDetails' => true,

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
        ],

        // Allocator settings
        'allocator_settings' => [
            'MysqlDatabase' => [
                'host' => 'localhost',
                'user' => 'root',
                'password' => 'root',
            ],
            'VirtualMachine' => [
                'base_vm_name' => 'ubuntu-provisioner',
                'vm_path' => '~/VirtualBox VMs/',
            ],
        ],
    ],
];
