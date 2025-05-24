<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class UserEloquentRepository
{
    public function createUser(string $email, string $name, string $password): User
    {
        return $this->query()->create([
            'email' => $email,
            'name' => $name,
            'password' => Hash::make($password),
        ]);
    }

    protected function query(): Builder
    {
        return User::query();
    }

    public function getUserByEmail(string $email): User
    {
        return $this->query()->where('email', $email)->first();
    }

    public function updateUser(int $userId, string $email = null, string $name = null): User
    {
        $user = $this->getUserById($userId);
        if ($email) {
            $user->email = $email;
        }
        if ($name) {
            $user->name = $name;
        }
        $user->save();
        return $user;
    }

    public function getUserById(int $userId): User
    {
        return $this->query()->findOrFail($userId);
    }
}
