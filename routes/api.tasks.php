<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', [TaskController::class, 'index']);
Route::get('/{task_id}', [TaskController::class, 'find']);
Route::post('/', [TaskController::class, 'store']);
Route::put('/{task_id}', [TaskController::class, 'update']);
Route::delete('/{task_id}', [TaskController::class, 'destroy']);

// Asignar / desasignar responsables de una tarea
Route::post('/{task_id}/responsibles', [TaskController::class, 'addResponsibles']);
Route::delete('/{task_id}/responsibles', [TaskController::class, 'removeResponsibles']);