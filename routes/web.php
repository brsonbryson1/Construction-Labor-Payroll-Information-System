<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaborerController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaystubController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| These routes are loaded by the RouteServiceProvider and are assigned
| to the "web" middleware group.
|
*/

// Routes accessible to the public
Route::get('/', function () {
    return view('welcome');
});

// Authenticated Employee Portal Routes
// Requires login via Sanctum/Jetstream
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    
    // Main landing page after login
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // ADDED: About Page Route
    Route::get('/about', function () {
        return view('about'); 
    })->name('about');

    // Employee Clock In/Out and Time Logs
    Route::get('/time-records', function () {
        return view('time-records');
    })->name('time-records');
    
    // Employee Payroll History
    Route::get('/payroll-history', function () {
        return view('payroll-history');
    })->name('payroll-history');
    
    // Paystub Download
    Route::get('/paystub/{id}/download', [PaystubController::class, 'downloadPdf'])->name('paystub.download');

    // Admin & Manager Routes
    Route::middleware(['role:Admin,Manager'])->group(function () {
        // Laborers Management
        Route::get('/laborers', [LaborerController::class, 'index'])->name('laborers.index');
        Route::post('/laborers', [LaborerController::class, 'store'])->name('laborers.store');
        Route::get('/laborers/{id}', [LaborerController::class, 'show'])->name('laborers.show');
        Route::put('/laborers/{id}', [LaborerController::class, 'update'])->name('laborers.update');
        Route::delete('/laborers/{id}', [LaborerController::class, 'destroy'])->name('laborers.destroy');

        // Attendance Management
        Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');

        // Payroll Processing
        Route::get('/payroll', [PayrollController::class, 'index'])->name('payroll.index');
        Route::post('/payroll/generate', [PayrollController::class, 'generate'])->name('payroll.generate');
        Route::post('/payroll/generate/{id}', [PayrollController::class, 'generateForEmployee'])->name('payroll.generate.employee');
        Route::post('/payroll/generate-custom', [PayrollController::class, 'generateCustom'])->name('payroll.generate.custom');
        Route::get('/payroll/preview/{id}', [PayrollController::class, 'preview'])->name('payroll.preview');
    });

    // Admin Only Routes
    Route::middleware(['role:Admin'])->group(function () {
        // Reports
        Route::get('/reports', function () {
            return view('reports.index');
        })->name('reports.index');
        Route::get('/reports/payroll', [ReportController::class, 'payroll'])->name('reports.payroll');
        Route::get('/reports/attendance', [ReportController::class, 'attendance'])->name('reports.attendance');
        Route::get('/reports/employees', [ReportController::class, 'employees'])->name('reports.employees');
        Route::get('/reports/analytics', [ReportController::class, 'analytics'])->name('reports.analytics');

        // User Management
        Route::get('/users', function () {
            return view('users.index');
        })->name('users.index');

        // User API Routes
        Route::post('/api/users', [UserController::class, 'store']);
        Route::put('/api/users/{id}', [UserController::class, 'update']);
        Route::delete('/api/users/{id}', [UserController::class, 'destroy']);

        // Settings
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/api/settings', [SettingController::class, 'update']);
    });
});