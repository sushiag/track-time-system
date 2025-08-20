<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CheckinController;

// Employee management (Admin only)
Route::post('/employees', [EmployeeController::class, 'store']);
Route::get('/employees', [EmployeeController::class, 'index']);

// Employee check-in / check-out
Route::post('/checkin', [CheckinController::class, 'checkin']);
Route::post('/checkout', [CheckinController::class, 'checkout']);
Route::get('/history/{employeeId}', [CheckinController::class, 'history']);
