<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function (Request $request) {
    $nome = $request -> nome ?? "Gabriel";
    return view('inicial', ["nome" => $nome]);
});

Route::post('/', function(Request $request){
    $nome = $request -> nome;
    return view('inicial', ["nome" => $nome]);
});

Route::get('/sobre', function () {
    return view('sobre');
});

Route::get('/sign-up', function () {
    return view('Auth/signUp');
});

Route::post('/sign-up', [UserController::class, 'store']);