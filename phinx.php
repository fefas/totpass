<?php

return [
    'paths' => [
        'migrations' => __DIR__.'/database/migrations',
    ],

    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_database' => 'production',

        'production' => [
            'adapter' => 'sqlite',
            'name' => __DIR__.'/totpass.sqlite',
            'charset' => 'utf8',
        ],
    ],

    'version_order' => 'creation',
];
