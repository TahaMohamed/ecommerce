<?php

use Illuminate\Support\Facades\Route;

Route::post('login', 'Auth\LoginController@login');
Route::post('register', 'Auth\RegisterController@register');
Route::post('verify', 'Auth\RegisterController@verify');
