<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('live', function () {
    return response()->json(['service' => 'users', 'version' => 1], 200);
});

Route::get("", [UserController::class, "index"])->name('users.index');
Route::get("{user_id}", [UserController::class, "find"])->name('users.find');
Route::post('', [UserController::class, 'store'])->name('users.store');
Route::put('{user_id}', [UserController::class, 'update'])->name('users.update');
Route::delete('{user_id}', [UserController::class, 'destroy'])->name('users.destroy');