<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Auth::routes(['register' => false]);

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    Route::middleware('auth')->get('/profile', [ProfileController::class, 'show']);

    // Home Route
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Profile Routes
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('profile'); // View Profile
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit'); // Edit Profile
        Route::put('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    });

    // Admin-only routes
    Route::middleware(['role:admin'])->group(function () {
        // Employee Management Routes
        Route::prefix('employee')->group(function () {
            Route::get('/add', [EmployeeController::class, 'index'])->name('employee.add'); // Add Employee
            Route::get('/master', [EmployeeController::class, 'master'])->name('employee.master'); // Employee Master List
            Route::post('/store', [EmployeeController::class, 'store'])->name('employee.store'); // Store Employee
            Route::get('/edit/{id}', [EmployeeController::class, 'edit'])->name('employee.edit'); // Edit Employee
            Route::put('/update/{id}', [EmployeeController::class, 'update'])->name('employee.update'); // Update Employee
            Route::delete('/delete/{id}', [EmployeeController::class, 'destroy'])->name('employee.delete'); // Delete Employee
            Route::post('/restore/{id}', [EmployeeController::class, 'restore'])->name('employee.restore'); // Restore Employee
        });
        // Attendance Management Routes (admin can see all)
        Route::resource('attendance', App\Http\Controllers\AttendanceController::class);
        // Leave Management Routes (admin can see all)
        Route::resource('leave', App\Http\Controllers\LeaveController::class);
    });

    // Employee-only routes
    Route::middleware(['role:employee'])->group(function () {
        // Attendance (employee can only mark/view their own)
        Route::get('attendance/create', [App\Http\Controllers\AttendanceController::class, 'create'])->name('attendance.create');
        // Leave (employee can only request/view their own)
        Route::get('leave/create', [App\Http\Controllers\LeaveController::class, 'create'])->name('leave.create');
        Route::post('leave', [App\Http\Controllers\LeaveController::class, 'store'])->name('leave.store');
    });

    // Allow both admin and employee to mark attendance
    Route::post('attendance', [App\Http\Controllers\AttendanceController::class, 'store'])->name('attendance.store')->middleware('auth');
});