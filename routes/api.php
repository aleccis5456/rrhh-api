<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class , 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/reports/employee', [ReportController::class, 'employeeReport'])->middleware('auth:sanctum');
Route::get('/reports/attendance', [ReportController::class, 'anttendanceReport'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function(){
    Route::apiResource('employee', (EmployeeController::class));
    Route::apiResource('department', (DepartmentController::class));
    Route::apiResource('attendance', (AttendanceController::class));
});


