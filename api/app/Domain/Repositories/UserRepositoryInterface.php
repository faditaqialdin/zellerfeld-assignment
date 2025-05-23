<?php

namespace App\Domain\Repositories;

use App\Domain\Models\User;

interface UserRepositoryInterface
{
    public function getUser(int $userId): User;

    public function updateUser(int $userId, string $email = null, string $name = null): User;
}
