<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\postController;
use App\Http\Controllers\API\AuthController;

Route::group(['middleware'=>'jwt.verify'],function(){
    Route::get("/posts",[postController::class,"index"]);

    Route::get("/post/{id}",[postController::class,"show"]);
    Route::post("/post/create",[postController::class,"store"]);
    Route::post("/post/update/{id}",[postController::class,"update"]);
    Route::get("/post/delete/{id}",[postController::class,"destroy"]);
});



Route::group(['middleware'=>"api","prefix"=>"auth"],function($router){
    Route::post('/login',[AuthController::class,"login"]);
    Route::post('/register',[AuthController::class,"register"]);
    Route::post('/logout',[AuthController::class,"logout"]);
    Route::post('/refresh',[AuthController::class,"refresh"]);
    Route::get('/user-profile',[AuthController::class,"userProfile"]);
});
