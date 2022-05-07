<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => '/api'], function () use ($router) {
    $router->get('/reset', action: 'ResetController@index');
    $router->get('/balance', action: 'BalanceController@index');
    $router->get('/event', action: 'BalanceController@index');
});