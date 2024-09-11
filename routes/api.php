<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ConversationController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource("user", UserController::class);

Route::get('/conversation/index',[ConversationController::class,'index'])->middleware('auth:sanctum');
Route::get('/conversation/show/{user}',[ConversationController::class,'index']);
Route::post('/conversation/create',[ConversationController::class,'index']);

Route::post('/login',[AuthController::class,'login']);
Route::delete('/logout',[AuthController::class,'logout'])->middleware('auth:sanctum');