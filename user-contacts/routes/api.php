<?php

use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('logtest', function () {
    Log::warning('Teste de log');

    return response()->json(['message' => 'Log gravado']);
});
Route::post('register', UserController::class.'@register');
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth',

], function ($router) {

    Route::post('login', AuthController::class.'@login');
    Route::post('logout', AuthController::class.'@logout');
    Route::post('refresh', AuthController::class.'@refresh');
    Route::post('me', AuthController::class.'@me');
});
Route::apiResource('contacts', ContactController::class)->middleware('auth:api');

Route::get('/', function () {
    return response()->json(['message' => 'Welcome to the API']);
});
