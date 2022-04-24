<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\OrganizationsController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GradesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth
require __DIR__.'/auth.php';

// Dashboard

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

// Users

Route::get('users', [UsersController::class, 'index'])
    ->name('users')
    ->middleware('auth');

Route::get('users/create', [UsersController::class, 'create'])
    ->name('users.create')
    ->middleware('auth');

Route::post('users', [UsersController::class, 'store'])
    ->name('users.store')
    ->middleware('auth');

Route::get('users/{user}/edit', [UsersController::class, 'edit'])
    ->name('users.edit')
    ->middleware('auth');

Route::put('users/{user}', [UsersController::class, 'update'])
    ->name('users.update')
    ->middleware('auth');

Route::delete('users/{user}', [UsersController::class, 'destroy'])
    ->name('users.destroy')
    ->middleware('auth');

Route::put('users/{user}/restore', [UsersController::class, 'restore'])
    ->name('users.restore')
    ->middleware('auth');

// Students

Route::get('students', [StudentsController::class, 'index'])
    ->name('students')
    ->middleware('auth');

Route::get('students/create', [StudentsController::class, 'create'])
    ->name('students.create')
    ->middleware('auth');

Route::post('students', [StudentsController::class, 'store'])
    ->name('students.store')
    ->middleware('auth');

Route::get('students/{student}/edit', [StudentsController::class, 'edit'])
    ->name('students.edit')
    ->middleware('auth');

Route::put('students/{student}', [StudentsController::class, 'update'])
    ->name('students.update')
    ->middleware('auth');

Route::delete('students/{student}', [StudentsController::class, 'destroy'])
    ->name('students.destroy')
    ->middleware('auth');

Route::put('students/{student}/restore', [StudentsController::class, 'restore'])
    ->name('students.restore')
    ->middleware('auth');

// GPA

Route::get('grades', [GradesController::class, 'index'])
    ->name('grades')
    ->middleware('auth');

Route::get('grades/create', [GradesController::class, 'create'])
    ->name('grades.create')
    ->middleware('auth');

Route::post('grades', [GradesController::class, 'store'])
    ->name('grades.store')
    ->middleware('auth');

Route::get('grades/{grade}/edit', [GradesController::class, 'edit'])
    ->name('grades.edit')
    ->middleware('auth');

Route::put('grades/{grade}', [GradesController::class, 'update'])
    ->name('grades.update')
    ->middleware('auth');

Route::delete('grades/{grade}', [GradesController::class, 'destroy'])
    ->name('grades.destroy')
    ->middleware('auth');

Route::put('grades/{grade}/restore', [GradesController::class, 'restore'])
    ->name('grades.restore')
    ->middleware('auth');

// Reports

Route::get('reports', [ReportsController::class, 'index'])
    ->name('reports')
    ->middleware('auth');

// Images

Route::get('/img/{path}', [ImagesController::class, 'show'])
    ->where('path', '.*')
    ->name('image');
