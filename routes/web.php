<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $nome = "Anderson";
    return view('inicial', ["nome" => $nome]);
});

Route::get('/sobre', function () {
    return view('about');
});
