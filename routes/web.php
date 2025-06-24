<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\{LoginController, RegisterController};
use App\Http\Controllers\Admin\{FormController, DashboardController};



Route::get('/', function () {
    return view('admin.auth.login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/login', [LoginController::class, 'login'])->name('admin.login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin/dashboard',[DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/form', [FormController::class, 'showCreateForm'])->name('admin.forms.index');
    Route::post('/admin/form', [FormController::class, 'createForm'])->name('admin.forms.create');
    Route::get('/admin/{form}/edit', [FormController::class, 'editForm'])->name('admin.forms.edit');



});



