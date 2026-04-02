<?php

use App\Http\Controllers\MaterialController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Routes user
Route::post('/sign-up', [UserController::class, 'store']);

// Routes material
Route::post('material', [MaterialController::class, 'store']);