<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\{LoginController, RegisterController};
use App\Http\Controllers\Admin\{FormController};



Route::get('/', function () {
    return view('admin.auth.login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/login', [LoginController::class, 'login'])->name('admin.login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin/dashboard', fn() => view('admin.pages.dashboard'))->name('admin.dashboard');
    Route::get('/admin/form', fn() => view('admin.pages.form'))->name('admin.forms.index');
    Route::post('/admin/form', [FormController::class, 'createForm'])->name('admin.forms.create');


});



