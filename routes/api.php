<?php

use Illuminate\Support\Facades\Route;

Route::namespace('Auth')->group(function () {
    Route::post('login', 'LoginController@login');
    Route::post('register', 'RegisterController@register');
    Route::post('verify', 'RegisterController@verify');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::namespace('Merchant')->group(function () {
        // Merchant Store
        Route::get('stores', "StoreController@index");
        Route::put('stores', "StoreController@update");
    });
});