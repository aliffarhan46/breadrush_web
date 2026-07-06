<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect()->route('register');
});

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/register-google', [AuthController::class, 'googleRegister'])->name('register.google');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/login-google', [AuthController::class, 'googleLogin'])->name('login.google');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/home', function () {
    return view('home');
})->middleware('auth')->name('home');

Route::get('/menu', function () {
    return view('menu');
})->middleware('auth')->name('menu');
