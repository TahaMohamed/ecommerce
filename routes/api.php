<?php

use App\Http\Middleware\{ConsumerMiddleware, MerchantMiddleware};
use Illuminate\Support\Facades\Route;

Route::namespace('Auth')->group(function () {
    Route::post('login', 'LoginController@login');
    Route::post('register', 'RegisterController@register');
    Route::post('verify', 'RegisterController@verify');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::namespace('Merchant')->middleware(MerchantMiddleware::class)->prefix('merchant')->group(function () {
        // Merchant Store
        Route::get('stores', "StoreController@index");
        Route::put('stores', "StoreController@update");
        // Store Product
        Route::apiResource('products','ProductController');
    });
    
    Route::namespace('Consumer')->middleware(ConsumerMiddleware::class)->prefix('consumer')->group(function () {
        // Consumer Store
        Route::apiResource('stores', "StoreController")->only('index','show');
        // Store Product
        Route::apiResource('store.products','ProductController')->only('index','show')->shallow();
        // Cart
        Route::apiResource('carts','CartController')->except('update');
    });
});