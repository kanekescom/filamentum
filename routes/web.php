<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Authentication redirects to Filament routes
Route::get('/login', function () {
    return redirect()->route('filament.app.auth.login');
})->name('login');

Route::get('/register', function () {
    return redirect()->route('filament.app.auth.register');
})->name('register');

Route::get('/password-reset', function () {
    return redirect()->route('filament.app.auth.password-reset.request');
})->name('password.request');

Route::get('/password-reset/reset/{token}', function ($token) {
    return redirect()->route('filament.app.auth.password-reset.reset', ['token' => $token]);
})->name('password.reset');
