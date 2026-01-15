<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

$app = new Illuminate\Foundation\Application(
    dirname(__DIR__)
);

/*
|--------------------------------------------------------------------------
| Fix public path (DirectAdmin / shared hosting)
|--------------------------------------------------------------------------
*/
$app->bind('path.public', function () {
    return base_path() . '/../';
});

/*
|--------------------------------------------------------------------------
| IMPORTANT: Force correct .env location
|--------------------------------------------------------------------------
| This fixes the issue where Laravel was trying to load:
| vendor/markury/src/.env (which does NOT exist)
|
| We explicitly tell Laravel to use the project root .env file.
|
*/
$app->useEnvironmentPath(base_path());
$app->loadEnvironmentFrom('.env');

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
*/

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

/*
|--------------------------------------------------------------------------
| REMOVE THIS LINE (DO NOT USE)
|--------------------------------------------------------------------------
| ❌ $app->useEnvironmentPath(realpath(__DIR__.'/../vendor/markury/src/'));
|
| It was breaking the application.
|--------------------------------------------------------------------------
*/

return $app;
