<?php

use App\Http\Controllers\UserController;
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

//Route::post('/sign-up', [UserController::class, 'store']);

Route::get('/materiais', function() {
    return view('App/materials/table');
});

Route::post('/materiais', function() {
    return view('materials/table');
});