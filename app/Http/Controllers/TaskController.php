<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskCreateRequest;
use App\Services\TaskService;
use Illuminate\Http\Request;

// Alumno: Carlos Alejandro Ambriz
class TaskController extends Controller
{
    public function __construct(private TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index(Request $request)
    {
        $result = $this->taskService->getAll();
        return response()->json(['data' => $result], 200);
    }

    public function find(Request $request, int $task_id)
    {
        $result = $this->taskService->find($task_id);
        return response()->json(['data' => $result], 200);
    }

    public function store(TaskCreateRequest $request)
    {
        $result = $this->taskService->store($request);
        return response()->json(['data' => $result], 201);
    }

    public function update(Request $request, int $task_id)
    {
        $result = $this->taskService->update($request, $task_id);
        return response()->json(['data' => $result], 200);
    }

    public function destroy(Request $request, int $task_id)
    {
        $this->taskService->destroy($task_id);
        return response()->json([], 204);
    }
}