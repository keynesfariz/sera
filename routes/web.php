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

$router->get('/', function () {
    return 'CRUD Firebase Firestore';
});

$router->get('/denom-filter[/{filterAmount}]', 'DenomFilterController');

$router->group(['prefix' => 'api/v1'], function () use ($router) {
    
    $router->group(['prefix' => '{database}/posts'], function () use ($router) {
        $router->get('/', 'PostController@index');
        $router->post('/', 'PostController@store');
        $router->put('/{id}', 'PostController@update');
        $router->delete('/{id}', 'PostController@destroy');
        $router->get('/{id}', 'PostController@show');
    });
    
});