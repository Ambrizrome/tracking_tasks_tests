<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//importacion de api.teams.php por Carlos Ambriz

Route::get('/', function (Request $request) {
    return response()->json(['live' => 'Tracking Task API is running', 'version' => '1'], 200);
});

Route::prefix('teams')->group(function () {
    require __DIR__ . '/api.teams.php';
});

//importacion de api.tasks.php por Carlos Ambriz

Route::prefix('tasks')->group(function () {
    require __DIR__ . '/api.tasks.php';
});

//importacion de api.auth.php por Carlos Ambriz

Route::prefix('auth')->group(function () {
    require __DIR__ . '/api.auth.php';
});

//importacion de api.users.php por Carlos Ambriz

Route::prefix('users')->group(function () {
    require __DIR__ . '/api.users.php';
});