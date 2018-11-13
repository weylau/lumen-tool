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
$router->group([
    'namespace'  => 'Callback',
    'prefix'     => 'callback',
//    'middleware' => 'Console.Authenticate',
], function () use ($router) {
    $router->post('/test', ['uses' => 'IndexController@test', 'as' => '']);
});
