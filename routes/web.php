<?php

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

$router->post('/auth/register', 'AuthController@postRegister');
$router->post('/auth/login', 'AuthController@postLogin');

$router->get('/pass', 'PassController@getIndex');

$router->get('/vendor/pass', 'VendorPassController@index');
$router->post('/vendor/pass', 'VendorPassController@store');
$router->patch('/vendor/pass/{id}', 'VendorPassController@update');
$router->delete('/vendor/pass/{id}', 'VendorPassController@destroy');

$router->post('/stamp', 'StampController@store');
