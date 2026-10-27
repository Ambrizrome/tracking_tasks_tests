<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\User;

class UserService {
    public function getAll(): array 
    {
        $users = User::get()->toArray();
        return $users;
    }

    public function find(int $user_id): User 
    {
        $user = User::findOrFail($user_id);
        return $user;
    }

    public function store(Request $request): User
    {
        $user = User::create($request->toArray());
        return $user;
    }

    public function update(Request $request, int $user_id): User
    {
        $user = $this->find($user_id);
        $user->update($request->toArray());
        return $user;
    }

    public function destroy(int $user_id)
    {
        $user = $this->find($user_id);
        $user->delete();
    }
}