<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->namespace('App\Http\Controllers\Api\V1')->group(function () {
    Route::apiResource('users', \App\Http\Controllers\Api\V1\UserController::class);
});

