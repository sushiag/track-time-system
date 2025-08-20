<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CheckinController;

// Default home page
Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

// Dashboard route (only for logged-in users)
Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ================== ADMIN ROUTES ==================
Route::middleware(['auth', 'verified'])->group(function () {
    // Manage employees
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
    Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
});

// ================== EMPLOYEE ROUTES ==================
Route::middleware(['auth'])->group(function () {
    Route::post('/checkin', [CheckinController::class, 'checkin'])->name('checkin');
    Route::post('/checkout', [CheckinController::class, 'checkout'])->name('checkout');
});


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
