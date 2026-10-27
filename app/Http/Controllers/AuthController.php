<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

// Alumno: Carlos Alejandro Ambriz
class AuthController extends Controller
{
    public function __construct(private AuthService $authService) {}

    public function login(AuthRequest $request)
    {
        $result = $this->authService->login($request->validated());

        if (!$result) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return response()->json(['data' => $result], 200);
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request->user());
        return response()->json([], 204);
    }
}