<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Livewire\CourseForm;
use App\Livewire\CourseList;
use App\Livewire\PerhitunganSaw;
use App\Livewire\ResultDisplay;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/login', [LoginController::class, 'showLoginForm']);
Route::post('/login', [LoginController::class, 'login'])->name('login.perform');

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.store');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Livewire Routes
Route::get('/dashboard', Dashboard::class)->middleware('auth')->name('dashboard');

Route::get('/user-detail', [UserController::class, 'profile'])
    ->middleware('auth')
    ->name('user.detail');

Route::get('/user-detail/edit', [UserController::class, 'edit'])
    ->middleware('auth')
    ->name('user.edit');

Route::put('/user-detail', [UserController::class, 'update'])
    ->middleware('auth')
    ->name('user.update');

Route::get('/input-data', CourseForm::class)->middleware('auth')->name('input-data');
Route::get('/all-data', CourseList::class)->middleware('auth')->name('all-data');
Route::get('/all-data/{id}/edit', CourseForm::class)->middleware('auth')->name('all-data.edit');

Route::get('/perhitungan', PerhitunganSaw::class)->middleware('auth')->name('perhitungan');
Route::get('/result', ResultDisplay::class)->middleware('auth')->name('result');
