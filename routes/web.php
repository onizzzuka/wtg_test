<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login')->name('login.post');

    Route::get('/register', 'showRegister')->name('register');
    Route::post('/register', 'register')->name('register.post');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', [ChatController::class, 'index'])->name('home');

    Route::prefix('chat')->name('chat.')->controller(ChatController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/messages/{user}', 'messages')->name('messages');
        Route::post('/messages', 'store')->name('messages.store');
    });
});
