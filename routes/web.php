<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TeacherController;
use App\Http\Controllers\Api\StudentController;
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

    Route::get('/account-type', function () {
        return view('Auth.accountType');
    })->name('accountType');

    Route::get('/teachers-complete-profile', function () {
        return view('Auth.teacher');
    })->name('teachers-complete-profile');

    Route::post('/account-type', [UserController::class, 'selectRole'])->name('accountType.store');

    Route::post('/logout', [UserController::class, 'logout'])->middleware('auth')->name('logout');

    Route::post('/teachers-complete-profile', [TeacherController::class, 'store'])
    ->name('teachers-complete-profile.store');

    Route::get('/students-complete-profile', function () {
        return view('Auth.student');
    })->name('students.profile');

    Route::post('/students-complete-profile', [StudentController::class, 'store'])->name('students.profile.store');

    Route::get('/materiais', function () {
        return view('App.materials.table');
    })->middleware('permission:subjects.*')
      ->name('classes');

    Route::get('/teste-admin', function () {
        return 'Você passou na autorização!';
    })->middleware('permission:users.*');

    Route::get('/debug', function () {
        return [
            'roles' => auth()->user()->getRoleNames(),
            'permissions' => auth()->user()->getAllPermissions()->pluck('name'),
        ];
    });
});

Route::post('/materiais', function () {
    return view('materials.table');
});