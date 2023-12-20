<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FarmActivityController;
use App\Admin\Controllers\HomeController;
use Illuminate\Support\Facades\DB;
use App\Models\FarmActivity;
use Encore\Admin\Facades\Admin;
use Illuminate\Http\Request;

Route::view('/', function () {
    die('hello');
});
Route::view('/test', function () {
    die('hello');
});
Route::view('auth/register', 'auth.register');
