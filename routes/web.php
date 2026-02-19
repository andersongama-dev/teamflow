<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('inicial');
});

Route::get('/sobre', function () {
    return view('about');
});
