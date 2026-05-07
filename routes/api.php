<?php

use App\Http\Controllers\Api\MaterialController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

// Routes user
Route::post('/sign-up', [UserController::class, 'store']);

// Routes material
Route::apiResource('materials', MaterialController::class);