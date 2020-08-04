<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->get('users', 'UsersController@index');

    $router->get('users/create', 'UsersController@create');
    $router->post('users', 'UsersController@store');

    $router->get('users/{id}/edit', 'UsersController@edit');
    $router->put('users/{id}', 'UsersController@update');


    $router->get('topics', 'topicsController@index');

    // 新增
    $router->get('topics/create', 'topicsController@create');
    $router->post('topics', 'topicsController@store');

    // 编辑
    $router->get('topics/{id}/edit', 'topicsController@edit');
    $router->put('topics/{id}', 'topicsController@update');
});
