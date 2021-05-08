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
        ['prefix' => 'favorites', 'middleware' => 'auth'],
        function () use ($router) {
            $router->get('/artists', [
                'as' => 'artists',
                'uses' => 'ArtistsController@GetFavorites',
            ]);
            $router->get('/tracks', [
                'as' => 'tracks',
                'uses' => 'TracksController@GetFavorites',
            ]);
        }
    );
    $router->group(
        ['prefix' => 'followed', 'middleware' => 'auth'],
        function () use ($router) {
            $router->get('/artists', [
                'as' => 'artists',
                'uses' => 'ArtistsController@GetFollowed',
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

    $router->group(
        ['prefix' => 'reports', 'middleware' => 'auth'],
        function () use ($router) {
            $router->get('/favorite-genres', [
                'as' => 'reports.genre',
                'uses' => 'ReportsController@FavoriteGenres',
            ]);
           
        }
    );
});
