<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserEloquentRepository
{
    public function createUser(string $email, string $name, string $password): User
    {
        return $this->query()->create([
            'email' => $email,
            'name' => $name,
            'password' => $password,
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

    public function updateUser(int $userId, string $email = null, string $name = null, string $password = null): User
    {
        $user = $this->getUserById($userId);
        if ($email) {
            $user->email = $email;
        }
        if ($name) {
            $user->name = $name;
        }
        if ($password) {
            $user->password = $password;
        }
        $user->save();
        return $user;
    }

    public function getUserById(int $userId): User
    {
        return $this->query()->findOrFail($userId);
    }
}
