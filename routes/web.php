<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserController::class, 'showLoginForm'])->name('login');
Route::get('/login', [UserController::class, 'showLoginForm']);
Route::post('/login', [UserController::class, 'login'])->name('login.perform');

Route::get('/register', [UserController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [UserController::class, 'register'])->name('register.store');

Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard', ['title' => 'Dashboard']);
})->middleware('auth')->name('dashboard');

Route::get('/user-detail', [UserController::class, 'profile'])
    ->middleware('auth')
    ->name('user.detail');

Route::get('/user-detail/edit', [UserController::class, 'edit'])
    ->middleware('auth')
    ->name('user.edit');

Route::put('/user-detail', [UserController::class, 'update'])
    ->middleware('auth')
    ->name('user.update');

Route::get('/input-data', function () {
    return view('input-data', ['title' => 'Input Data']);
})->middleware('auth')->name('input-data');

Route::get('/perhitungan', function () {
    return view('perhitungan', ['title' => 'Calculation']);
})->middleware('auth')->name('perhitungan');

Route::get('/result', function () {
    return view('result', ['title'=> 'Result']);
})->middleware('auth')->name('result');
