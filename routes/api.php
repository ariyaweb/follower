<?php

use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::group(['prefix' => 'v1'], function() {

    // create new user
    Route::post('/user/create',[UserController::class , 'createuser' ]);

    // order route's
    Route::group(['prefix' => 'order'], function() {
        Route::post('/create',[OrderController::class , 'create' ]);
    });

});
