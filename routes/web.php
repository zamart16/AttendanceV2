<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AdminController;


Route::post('/attendance', [AttendanceController::class, 'store'])
    ->name('attendance.store')
    ->middleware('web');

Route::get('/bac-attendance', [AttendanceController::class, 'bac'])
    ->name('bac.attendance');

Route::get('/admin-dashboard', [AdminController::class, 'dashboard'])
    ->name('admin.dashboard');

Route::post('/admin/controllers/{controller}/toggle', [AdminController::class, 'toggleController']);

