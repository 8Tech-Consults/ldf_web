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
    $router->resource('users', UserController::class);
    $router->resource('farms', FarmController::class);
    $router->resource('farmers', FarmerController::class);
    $router->resource('breeds', BreedController::class);
    $router->resource('animals', AnimalController::class);
    $router->resource('animal-health-records', AnimalHealthController::class);
    $router->resource('vector-and-diseases', VectorAndDiseaseController::class);
    $router->resource('vets', VetController::class);
    $router->resource('service-providers', ServiceProviderController::class);
    $router->resource('production-records', ProductionController::class);
    $router->resource('financial-records', FinancialRecordController::class);
    $router->resource('farm-activities', FarmActivityController::class);
    $router->resource('livestock-types', LivestockTypeController::class);
    $router->resource('cooperatives', CooperativeController::class);
});
