<?php

use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::apiResource('contacts', ContactController::class)->middleware('auth:api');
Route::post('register', UserController::class . '@register');

Route::get('/', function () {
    return response()->json(['message' => 'Welcome to the API']);
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', AuthController::class. '@login');
    Route::post('logout', AuthController::class . '@logout');
    Route::post('refresh', AuthController::class . '@refresh');
    Route::post('me', AuthController::class. '@me');
});