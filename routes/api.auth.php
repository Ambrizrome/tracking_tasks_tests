<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Alumno: Carlos Alejandro Ambriz
Route::post('login', [AuthController::class, 'login'])->name('auth.login');
Route::post('logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum')
    ->name('auth.logout');