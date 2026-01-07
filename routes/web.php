<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CalculationController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/login', [LoginController::class, 'showLoginForm']);
Route::post('/login', [LoginController::class, 'login'])->name('login.perform');

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.store');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

// User Profile
Route::get('/user-detail', [UserController::class, 'profile'])
    ->middleware('auth')
    ->name('user.detail');

Route::get('/user-detail/edit', [UserController::class, 'edit'])
    ->middleware('auth')
    ->name('user.edit');

Route::put('/user-detail', [UserController::class, 'update'])
    ->middleware('auth')
    ->name('user.update');

// Courses CRUD
Route::get('/courses', [CourseController::class, 'index'])->middleware('auth')->name('courses.index');
Route::get('/courses/create', [CourseController::class, 'create'])->middleware('auth')->name('courses.create');
Route::post('/courses', [CourseController::class, 'store'])->middleware('auth')->name('courses.store');
Route::get('/courses/{id}/edit', [CourseController::class, 'edit'])->middleware('auth')->name('courses.edit');
Route::put('/courses/{id}', [CourseController::class, 'update'])->middleware('auth')->name('courses.update');
Route::delete('/courses/{id}', [CourseController::class, 'destroy'])->middleware('auth')->name('courses.destroy');

// Legacy route aliases for compatibility
Route::get('/input-data', [CourseController::class, 'create'])->middleware('auth')->name('input-data');
Route::get('/all-data', [CourseController::class, 'index'])->middleware('auth')->name('all-data');
Route::get('/all-data/{id}/edit', [CourseController::class, 'edit'])->middleware('auth')->name('all-data.edit');

// SAW Calculation
Route::get('/perhitungan', [CalculationController::class, 'index'])->middleware('auth')->name('perhitungan');
Route::post('/perhitungan', [CalculationController::class, 'calculate'])->middleware('auth')->name('perhitungan.calculate');
Route::get('/result', [CalculationController::class, 'result'])->middleware('auth')->name('result');
