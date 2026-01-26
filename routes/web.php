<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// --- Public Routes ---
Route::get('/', fn() => view('welcome'));

// --- Authentication ---
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login')->middleware('guest');
    Route::post('/login', 'login')->middleware('guest');
    Route::post('/logout', 'logout')->name('logout')->middleware('auth');
});

// --- Protected Routes (Authenticated Users) ---
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    // Calendar Routes
    Route::prefix('calendar')->name('calendar.')->group(function () {
        Route::get('/', [CalendarController::class, 'index'])->name('index');
        Route::get('/events', [CalendarController::class, 'events'])->name('events');
    });

    // Resource Routes
    Route::resource('tasks', TaskController::class);
    Route::resource('events', EventController::class);

    // --- Admin Only Routes ---
    Route::middleware(['admin'])->group(function () {
        Route::resource('users', UserController::class);
    });
});
