<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('vets', UserController::class);
    $router->resource('inputs', UserController::class);
    $router->resource('farmers', UserController::class);
    $router->resource('farms', FarmController::class);
    $router->resource('animals', AnimalController::class);
    $router->resource('events', EventController::class);
    $router->resource('farm-activities', FarmActivityController::class); 
    $router->resource('paravet-requests', ParavetRequestController::class);
    $router->resource('products', ProductController::class);
    $router->resource('financial-records', FinancialRecordController::class);
    $router->resource('finance-accounts', FinanceAccountController::class); 

});
