<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserController::class, 'showLoginForm'])->name('login');
Route::get('/login', [UserController::class, 'showLoginForm']);
Route::post('/login', [UserController::class, 'login'])->name('login.perform');

Route::get('/register', [UserController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [UserController::class, 'register'])->name('register.store');

Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/dashboard', [CourseController::class, 'dashboard'])->middleware('auth')->name('dashboard');

Route::get('/user-detail', [UserController::class, 'profile'])
    ->middleware('auth')
    ->name('user.detail');

Route::get('/user-detail/edit', [UserController::class, 'edit'])
    ->middleware('auth')
    ->name('user.edit');

Route::put('/user-detail', [UserController::class, 'update'])
    ->middleware('auth')
    ->name('user.update');

Route::get('/input-data', [CourseController::class, 'inputData'])->middleware('auth')->name('input-data');
Route::post('/input-data', [CourseController::class, 'storeCourse'])->middleware('auth')->name('input-data.store');

Route::get('/all-data', [CourseController::class, 'index'])->middleware('auth')->name('all-data');
Route::get('/all-data/{id}/edit', [CourseController::class, 'edit'])->middleware('auth')->name('all-data.edit');
Route::put('/all-data/{id}/update', [CourseController::class, 'update'])->middleware('auth')->name('all-data.update');
Route::delete('/all-data/{id}/delete', [CourseController::class, 'destroy'])->middleware('auth')->name('all-data.destroy');

Route::get('/perhitungan', [CourseController::class, 'perhitungan'])->middleware('auth')->name('perhitungan');
Route::post('/perhitungan', [CourseController::class, 'storePerhitungan'])->middleware('auth')->name('perhitungan.store');

Route::get('/result', [CourseController::class, 'result'])->middleware('auth')->name('result');
