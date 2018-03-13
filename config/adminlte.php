<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Use Gravatar
    |--------------------------------------------------------------------------
    |
    | Acacha adminlte Laravel use Gravatar to obtain user's gravatars from email.
    | Set this option to false to avoid registering Gravatar service provider.
    | Be careful because default provided views depends on this service so adapt
    | views to your requirements.
    | See https://github.com/creativeorange/gravatar
    */

    'gravatar' => true,

    /*
    |--------------------------------------------------------------------------
    | Use GuestUser/NullUser design pattern
    |--------------------------------------------------------------------------
    |
    | Acacha adminlte Laravel use GuestUser/NullUser design pattern.
    | Set this option to false to avoid registering GuestUser service provider.
    | Be careful because default provided views depends on this service so adapt
    | views to your requirements.
    | See https://github.com/acacha/user
    | See https://laracasts.com/series/whip-monstrous-code-into-shape/episodes/19
    */

    'guestuser' => true,

    /*
    |--------------------------------------------------------------------------
    | Admin user migration
    |--------------------------------------------------------------------------
    |
    | Allow the migration to add a unique nullable username field to the users
    | table
    */

    'add_nullable_username' => true,

    /*
    |--------------------------------------------------------------------------
    | Admin user seeder name
    |--------------------------------------------------------------------------
    |
    | The name of the seeder to add admin user to database.
    */

    'AdminUserSeeder' => 'AdminUserSeeder.php',

    /*
    |--------------------------------------------------------------------------
    | Install routes
    |--------------------------------------------------------------------------
    |
    | The package Service Providers installs some routes like authorization routes (Auth::route)
    | and /home. You could disable this routes with this option but remember then to manage the
    | routes in your app.
    */

    'install_routes' => true

];
