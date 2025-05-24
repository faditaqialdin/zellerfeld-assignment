<?php

namespace App\Domain\Repositories;

use App\Domain\Models\User;

interface UserDomainRepositoryInterface
{
    public function createUser(string $email, string $name, string $password): User;

    public function getUserById(int $userId): User;

    public function getUserByEmail(string $email): User;

    public function updateUser(int $userId, string $email = null, string $name = null): User;
}
