<?php

use Illuminate\Support\Facades\Route;

Route::post('login', [Auth\AuthController::class, 'login']);
Route::post('register', [Auth\AuthController::class, 'register']);
