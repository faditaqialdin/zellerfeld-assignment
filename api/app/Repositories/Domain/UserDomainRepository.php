<?php

namespace App\Repositories\Domain;

use App\Domain\Models\User as DomainUser;
use App\Domain\Repositories\UserDomainRepositoryInterface;
use App\Models\User;
use App\Repositories\Eloquent\UserEloquentRepository;

readonly class UserDomainRepository implements UserDomainRepositoryInterface
{
    public function __construct(private UserEloquentRepository $userEloquentRepository)
    {
    }

    public function createUser(string $email, string $name, string $password): DomainUser
    {
        $user = $this->userEloquentRepository->createUser($email, $name, $password);
        return $this->domainUserFromEloquentUser($user);
    }

    protected function domainUserFromEloquentUser(User $user): DomainUser
    {
        return new DomainUser(
            id: $user->id,
            name: $user->name,
            email: $user->email,
            createdAt: $user->created_at->toDateTimeImmutable(),
        );
    }

    public function getUserById(int $userId): DomainUser
    {
        $user = $this->userEloquentRepository->getUserById($userId);
        return $this->domainUserFromEloquentUser($user);
    }

    public function getUserByEmail(string $email): DomainUser
    {
        $user = $this->userEloquentRepository->getUserByEmail($email);
        return $this->domainUserFromEloquentUser($user);
    }

    public function updateUser(int $userId, string $email = null, string $name = null): DomainUser
    {
        $user = $this->userEloquentRepository->updateUser($userId, $email, $name);
        return $this->domainUserFromEloquentUser($user);
    }
}
