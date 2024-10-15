<?php

use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [RegistrationController::class, 'index'])->name('index');
Route::get('/register', [RegistrationController::class, 'registerPage'])->name('register.page');
Route::post('/register', [RegistrationController::class, 'register'])->name('register');
Route::get('/search', [RegistrationController::class, 'searchStatus'])->name('search');
