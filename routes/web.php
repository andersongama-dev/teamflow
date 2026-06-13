<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('inicial');
});

Route::post('/', function(Request $request){
    $nome = $request -> nome;
    return view('inicial', ["nome" => $nome]);
});

Route::get('/sobre', function () {
    return view('about');
});

Route::get('/sign-up', function () {
    return view('Auth/signUp');
});

Route::get('/sign-in', function () {
    return view('Auth/signIn');
})->name('login');

Route::post('/sign-up', [UserController::class, 'store']);

Route::post('/sign-in', [UserController::class, 'login']);

Route::middleware('auth')->group(function () {
    Route::get('/materiais', function () {
        return view('App.materials.table');
    })->middleware(['auth', 'permission:subjects.*'])->name('classes');

    Route::get('/teste-admin', function () {
        return 'Você passou na autorização!';
    })->middleware(['auth', 'permission:users.delete']);

    Route::get('/debug', function () {
        return auth()->user()->getAllPermissions()->pluck('name');
    })->middleware('auth');

    Route::post('/materiais', function() {
    return view('materials/table');
});
});