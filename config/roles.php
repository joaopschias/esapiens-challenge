<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'administrator' => [
            'comment' => 'list,create,delete',
        ],
        'subscriber' => [],
        'user' => [
            'comment' => 'list,create,delete',
        ],
    ],

    'permissions_map' => [
        'list' => 'list',
        'create' => 'create',
        'read' => 'read',
        'update' => 'update',
        'delete' => 'delete',
    ],
];
