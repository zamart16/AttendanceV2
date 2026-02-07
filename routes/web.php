<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AdminController;

use Illuminate\Routing\Middleware\ValidateSignature;

Route::get('/', function () {
    return view('attendance.qr');
});

Route::post('/attendance', [AttendanceController::class, 'store'])
    ->name('attendance.store')
    ->middleware('web');

Route::get('/bac-attendance', [AttendanceController::class, 'bac'])
    ->name('bac.attendance');

// Route::get('/admin-dashboard', [AdminController::class, 'dashboard'])
//     ->name('admin.dashboard');
// Route::get('/admin-dashboard-bac', [AdminController::class, 'dashboard'])
//     ->name('admin.dashboard')
//     ->middleware(['auth', 'signed']);
Route::get('/admin-dashboard-bac', [AdminController::class, 'dashboard'])
    ->name('admin.dashboard')
    ->middleware(['auth', 'signed']);


Route::post('/admin/controllers/{controller}/toggle', [AdminController::class, 'toggleController']);


Route::get('/attendances/today-count', [AttendanceController::class, 'todayCount']);



Route::get('/admin/attendees', [AdminController::class, 'attendeesList']);
Route::get('/admin/attendees/realtime', [AdminController::class, 'attendeesRealtime']);

