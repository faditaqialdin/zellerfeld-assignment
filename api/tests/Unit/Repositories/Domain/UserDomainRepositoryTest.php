<?php

namespace Tests\Unit\Repositories\Domain;

use App\Models\User;
use App\Repositories\Domain\UserDomainRepository;
use App\Repositories\Eloquent\UserEloquentRepository;
use Carbon\CarbonImmutable;
use Mockery;
use Tests\TestCase;

class UserDomainRepositoryTest extends TestCase
{
    public function test_create_user(): void
    {
        $eloquentUser = $this->fakeEloquentUser();

        $eloquentRepo = Mockery::mock(UserEloquentRepository::class);
        $eloquentRepo->shouldReceive('createUser')
            ->once()
            ->with('test@example.com', 'Test User', 'secret')
            ->andReturn($eloquentUser);

        $domainRepo = new UserDomainRepository($eloquentRepo);

        $domainUser = $domainRepo->createUser('test@example.com', 'Test User', 'secret');

        $this->assertEquals($eloquentUser->id, $domainUser->getId());
        $this->assertEquals($eloquentUser->email, $domainUser->getEmail());
    }

    private function fakeEloquentUser(): User
    {
        $user = new User();
        $user->id = 1;
        $user->name = 'Test User';
        $user->email = 'test@example.com';
        $user->created_at = CarbonImmutable::now();

        return $user;
    }

    public function test_get_user_by_id(): void
    {
        $eloquentUser = $this->fakeEloquentUser();

        $eloquentRepo = Mockery::mock(UserEloquentRepository::class);
        $eloquentRepo->shouldReceive('getUserById')
            ->once()
            ->with(1)
            ->andReturn($eloquentUser);

        $domainRepo = new UserDomainRepository($eloquentRepo);

        $domainUser = $domainRepo->getUserById(1);

        $this->assertEquals(1, $domainUser->getId());
    }

    public function test_get_user_by_email(): void
    {
        $eloquentUser = $this->fakeEloquentUser();

        $eloquentRepo = Mockery::mock(UserEloquentRepository::class);
        $eloquentRepo->shouldReceive('getUserByEmail')
            ->once()
            ->with('test@example.com')
            ->andReturn($eloquentUser);

        $domainRepo = new UserDomainRepository($eloquentRepo);

        $domainUser = $domainRepo->getUserByEmail('test@example.com');

        $this->assertEquals('test@example.com', $domainUser->getEmail());
    }

    public function test_update_user(): void
    {
        $eloquentUser = $this->fakeEloquentUser();
        $eloquentUser->email = 'new@example.com';
        $eloquentUser->name = 'New Name';

        $eloquentRepo = Mockery::mock(UserEloquentRepository::class);
        $eloquentRepo->shouldReceive('updateUser')
            ->once()
            ->with(1, 'new@example.com', 'New Name')
            ->andReturn($eloquentUser);

        $domainRepo = new UserDomainRepository($eloquentRepo);

        $domainUser = $domainRepo->updateUser(1, 'new@example.com', 'New Name');

        $this->assertEquals('new@example.com', $domainUser->getEmail());
        $this->assertEquals('New Name', $domainUser->getName());
    }
}
