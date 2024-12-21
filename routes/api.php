<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiPostController;
use App\Http\Controllers\Api\ApiCommentController;
use App\Http\Controllers\Api\AuthController;
 


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


Route::middleware('auth:api')->group(function () {
    Route::apiResource('posts', ApiPostController::class);
    Route::apiResource('posts.comments', ApiCommentController::class);
});