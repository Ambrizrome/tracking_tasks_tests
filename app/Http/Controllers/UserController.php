<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request) 
    {
        $result = $this->userService->getAll();
        return response()->json(['data' => $result], 200);
    }

    public function find(Request $request, int $user_id)
    {
        $result = $this->userService->find($user_id);
        return response()->json(['data' => $result], 200);
    }

    public function store(Request $request)
    {
        $result = $this->userService->store($request);
        return response()->json(['data' => $result], 201);
    }

    public function update(Request $request, int $user_id)
    {
        $result = $this->userService->update($request, $user_id);
        return response()->json(['data' => $result], 201);
    }

    public function destroy(Request $request, int $user_id)
    {
        $this->userService->destroy($user_id);
        return response()->json([], 204);
    }
}
