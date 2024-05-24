<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->namespace('App\Http\Controllers\Api\V1')->group(function () {
    Route::apiResource('users', 'UserController')
        ->only('store');
    Route::post('tokens', 'TokenController@store')
        ->middleware('auth.basic.once');

    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('users', 'UserController')
            ->only('index');
    });
});

Route::prefix('v2')->namespace('App\Http\Controllers\Api\V2')->group(function () {
    //Routes for API v2
});
