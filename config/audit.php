<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Audit implementation
    |--------------------------------------------------------------------------
    |
    | Define which Audit model implementation should be used.
    |
    */

    'implementation' => Emtudo\Domains\Audits\Audit::class,

    /*
    |--------------------------------------------------------------------------
    | User Keys, Model & Resolver
    |--------------------------------------------------------------------------
    |
    | Define the User primary and foreign keys, Eloquent model and ID resolver
    | class.
    |
    */

    'user' => [
        'primary_key' => 'id',
        'foreign_key' => 'user_id',
        'model' => Emtudo\Domains\Users\User::class,
        'resolver' => Emtudo\Domains\Users\User::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Audit Events
    |--------------------------------------------------------------------------
    |
    | The Eloquent events that trigger an Audit.
    |
    */

    'events' => [
        'created',
        'updated',
        'deleted',
        'restored',
    ],

    /*
    |--------------------------------------------------------------------------
    | Strict mode
    |--------------------------------------------------------------------------
    |
    | Enable the strict mode when auditing?
    |
    */

    'strict' => false,

    /*
    |--------------------------------------------------------------------------
    | Audit timestamps
    |--------------------------------------------------------------------------
    |
    | Should the created_at, updated_at and deleted_at timestamps be audited?
    |
    */

    'timestamps' => false,

    /*
    |--------------------------------------------------------------------------
    | Audit threshold
    |--------------------------------------------------------------------------
    |
    | Specify a threshold for the amount of Audit records a model can have.
    | Zero means no limit.
    |
    */

    'threshold' => 0,

    /*
    |--------------------------------------------------------------------------
    | Audit Driver
    |--------------------------------------------------------------------------
    |
    | The default audit driver used to keep track of changes.
    |
    */

    'driver' => 'database',

    /*
    |--------------------------------------------------------------------------
    | Audit Drivers
    |--------------------------------------------------------------------------
    |
    | Available audit drivers and respective configurations.
    |
    */

    'drivers' => [
        'database' => [
            'table' => 'audits',
            'connection' => null,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Audit Console?
    |--------------------------------------------------------------------------
    |
    | Whether we should audit console events (eg. php artisan db:seed).
    |
    */

    'console' => false,
];
