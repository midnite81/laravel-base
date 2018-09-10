<?php

return [

    /*
    |--------------------------------------------------------------------------
    | User Model
    |--------------------------------------------------------------------------
    | Laravel-base comes with a set of commands which allow you to update the
    | user records via the command line. To enable, you just need to add the
    | model to the array.
    |
    */
    'user-models' => [
        'user' => '\App\Models\User',
    ],

    /*
    |--------------------------------------------------------------------------
    | Artisan commands
    |--------------------------------------------------------------------------
    | By default, Laravel-Base will attach its commands to the Laravel application
    | if you wish to turn this functionality off, please set the following
    | option to false
    |
    */
    'artisan-commands' => env('LB_ARTISAN_COMMANDS', 'true'),
];