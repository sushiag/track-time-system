<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CheckinController;

// Default home page
Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

// ===================== AUTHENTICATED ROUTES ===================== 
Route::middleware(['auth', 'verified'])->group(function () { 
    /** * Redirect users based on role * - Admins → Admin Dashboard * - Employees → Employee Dashboard */ 
    Route::get('/dashboard', function () { 
        return redirect()->route(auth()->user()->role === 'admin' ? 'admin.dashboard' : 'employee.dashboard'); })->name('dashboard');
// ===================== ADMIN ROUTES ===================== 
Route::middleware('role:admin')->group(function () { 
    Route::get('/admin/dashboard', function () {
        return Inertia::render('Dashboard/AdminDashboard'); })->name('admin.dashboard'); 
        // Manage employees 
    Route::prefix('employees')->name('employees.')->group(function () { 
    Route::get('/', [EmployeeController::class, 'index'])->name('index'); 
    Route::post('/', [EmployeeController::class, 'store'])->name('store'); 
    Route::delete('/{id}', [EmployeeController::class, 'destroy'])->name('destroy'); }); }); 
// ===================== EMPLOYEE ROUTES ===================== 
Route::middleware('role:employee')->group(function () { 
Route::get('/employee/dashboard', [CheckinController::class, 'dashboard'])->name('employee.dashboard'); 
Route::post('/checkin', [CheckinController::class, 'checkin'])->name('checkin'); 
Route::post('/checkout', [CheckinController::class, 'checkout'])->name('checkout'); }); });
 // ===================== OTHER ROUTES ===================== php artisan tinker
 
require __DIR__.'/settings.php';
 require __DIR__.'/auth.php';