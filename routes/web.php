<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Rotas públicas
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('inicial');
});

Route::post('/', function (Request $request) {
    return view('inicial', [
        'nome' => $request->nome
    ]);
});

Route::get('/sobre', fn () => view('about'));

Route::middleware('guest')->group(function () {
    Route::get('/sign-up', fn () => view('Auth.signUp'));
    Route::get('/sign-in', fn () => view('Auth.signIn'))->name('login');

    Route::post('/sign-up', [UserController::class, 'store']);
    Route::post('/sign-in', [UserController::class, 'login']);
});

/*
|--------------------------------------------------------------------------
| Rotas autenticadas
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

    Route::get('/account-type', fn () => view('Auth.accountType'))
        ->name('accountType');

    Route::post('/account-type', [UserController::class, 'selectRole'])
        ->name('accountType.store');

    Route::get('/teachers-complete-profile', fn () => view('Auth.teacher'))
        ->name('teachers.complete-profile');

    Route::post('/teachers-complete-profile', [TeacherController::class, 'store'])
        ->name('teachers.complete-profile.store');

    Route::get('/students-complete-profile', fn () => view('Auth.student'))
        ->name('students.complete-profile');

    Route::post('/students-complete-profile', [StudentController::class, 'store'])
        ->name('students.complete-profile.store');

    Route::resource('enrollments', EnrollmentController::class);

    Route::get('/debug', function () {
        return [
            'roles' => auth()->user()->getRoleNames(),
            'permissions' => auth()->user()->getAllPermissions()->pluck('name'),
        ];
    });
});

/*
|--------------------------------------------------------------------------
| Admin / Professor
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:Administrador|Professor'])->group(function () {

    Route::resource('subjects', SubjectController::class);

    Route::resource('classes', SchoolClassController::class);
});

/*
|--------------------------------------------------------------------------
| Notas e presença (todos autenticados com papéis permitidos)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:Administrador|Professor|Aluno'])->group(function () {

    Route::resource('grades', GradeController::class);
    Route::resource('attendances', AttendanceController::class);
});

/*
|--------------------------------------------------------------------------
| Permissão específica
|--------------------------------------------------------------------------
*/

Route::get('/teste-admin', function () {
    return 'Você passou na autorização!';
})->middleware(['auth', 'permission:users.*']);

/*
|--------------------------------------------------------------------------
| Materiais
|--------------------------------------------------------------------------
*/

Route::get('/materiais', function () {
    return view('App.materials.table');
});