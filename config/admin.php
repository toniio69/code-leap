<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Administrator Account
    |--------------------------------------------------------------------------
    |
    | These credentials are used by `AdminSeeder` to create or update the
    | local administrator account. Override them per environment in `.env`
    | (see `ADMIN_EMAIL`, `ADMIN_NAME`, `ADMIN_PASSWORD`) and never commit
    | real production credentials.
    |
    */

    'email' => env('ADMIN_EMAIL', 'admin@codeleap.com'),

    'name' => env('ADMIN_NAME', 'CodeLeap Admin'),

    'password' => env('ADMIN_PASSWORD', '1234'),

    'role' => env('ADMIN_ROLE', 'admin'),

];
