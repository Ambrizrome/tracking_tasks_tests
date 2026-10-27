<?php

use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

//endpoints por Carlos Ambriz

Route::get('live', function () {
    return response()->json(['service' => 'teams', 'version' => '1'], 200);
});

Route::get("", [TeamController::class, 'index'])->name('teams.index');
Route::get("{team_id}", [TeamController::class, "find"])->name('teams.find');
Route::post('', [TeamController::class, 'store'])->name('teams.store');
Route::put('{team_id}', [TeamController::class, 'update'])->name('teams.update');
Route::delete('{team_id}', [TeamController::class, 'destroy'])->name('teams.destroy');