<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\OrderController;

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

Route::get('/checkout', function () {
    return view('checkout');
})->middleware('auth')->name('checkout');

Route::get('/payment', function () {
    return view('payment');
})->middleware('auth')->name('payment');

use App\Http\Controllers\ProfileController;

Route::post('/payment/submit', [OrderController::class, 'store'])->middleware('auth')->name('payment.submit');
Route::get('/tracking/{id?}', [OrderController::class, 'showTracking'])->middleware('auth')->name('tracking');

Route::get('/profile', [ProfileController::class, 'index'])->middleware('auth')->name('profile');
Route::post('/profile', [ProfileController::class, 'update'])->middleware('auth')->name('profile.update');

