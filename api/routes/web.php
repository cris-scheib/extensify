<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->group(['prefix' => 'auth'], function () use ($router) {
        $router->post('/', [
            'as' => 'auth',
            'uses' => 'AuthController@Authenticate',
        ]);
        $router->get('/login', [
            'as' => 'login',
            'uses' => 'AuthController@Login',
        ]);
        $router->get('/logout', [
            'as' => 'logout',
            'uses' => 'AuthController@Logout',
        ]);
    });
    $router->group(
        ['prefix' => 'artists', 'middleware' => 'auth'],
        function () use ($router) {
            $router->get('/', [
                'as' => 'artists',
                'uses' => 'ArtistsController@Get',
            ]);
        }
    );
    $router->group(
        ['prefix' => 'tracks', 'middleware' => 'auth'],
        function () use ($router) {
            $router->get('/', [
                'as' => 'tracks',
                'uses' => 'TracksController@Get',
            ]);
        }
    );
    $router->group(
        ['prefix' => 'settings', 'middleware' => 'auth'],
        function () use ($router) {
            $router->get('/', [
                'as' => 'settings.get',
                'uses' => 'SettingsController@Get',
            ]);
            $router->post('/', [
                'as' => 'settings.update',
                'uses' => 'SettingsController@Update',
            ]);
        }
    );
});
