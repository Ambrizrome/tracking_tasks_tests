<?php

namespace App\Http\Controllers;

use App\Services\TeamService;
use Illuminate\Http\Request;

class TeamController extends Controller // Controlador de Team por script php artisan make:controller TeamController en terminal
                                        // por Carlos Alejandro Ambriz
{
    public function __construct(private TeamService $teamService)
    {
        $this->teamService = $teamService;
    }

    public function index(Request $request)
    {
        $result = $this->teamService->getAll();
        return response()->json(['data' => $result], 200);
    }

    public function find(Request $request, int $team_id)
    {
        $result = $this->teamService->find($team_id);
        return response()->json(['data' => $result], 200);
    }

    public function store(Request $request)
    {
        $result = $this->teamService->store($request);
        return response()->json(['data' => $result], 201);
    }

    public function update(Request $request, int $team_id)
    {
        $result = $this->teamService->update($request, $team_id);
        return response()->json(['data' => $result], 200);
    }

    public function destroy(Request $request, int $team_id)
    {
        $result = $this->teamService->destroy($team_id);
        return response()->json([], 204);
    }
}
