<?php

namespace Tests\Unit\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Eloquent\UserEloquentRepository;
use Illuminate\Database\Eloquent\Builder;
use Mockery;
use Tests\TestCase;

class UserEloquentRepositoryTest extends TestCase
{
    public function test_create_user(): void
    {
        $data = [
            'email' => 'test@example.com',
            'name' => 'Test User',
            'password' => 'secret',
        ];

        $createdUser = new User([
            'email' => $data['email'],
            'name' => $data['name'],
            'password' => $data['password'],
        ]);

        $queryMock = Mockery::mock(Builder::class);
        $queryMock->shouldReceive('create')
            ->once()
            ->with(Mockery::on(static function ($arg) use ($data) {
                return $arg['email'] === $data['email']
                    && $arg['name'] === $data['name'];
            }))
            ->andReturn($createdUser);

        $repo = Mockery::mock(UserEloquentRepository::class)->makePartial();
        $repo->shouldAllowMockingProtectedMethods();
        $repo->shouldReceive('query')->once()->andReturn($queryMock);

        $result = $repo->createUser($data['email'], $data['name'], $data['password']);

        $this->assertEquals($data['email'], $result->email);
    }

    public function test_get_user_by_id(): void
    {
        $email = 'one@example.com';
        $user = new User(['id' => 1, 'email' => $email]);

        $queryMock = Mockery::mock(Builder::class);
        $queryMock->shouldReceive('findOrFail')
            ->once()
            ->with(1)
            ->andReturn($user);

        $repo = Mockery::mock(UserEloquentRepository::class)->makePartial();
        $repo->shouldAllowMockingProtectedMethods();
        $repo->shouldReceive('query')->once()->andReturn($queryMock);

        $result = $repo->getUserById(1);
        $this->assertEquals($email, $result->email);
    }

    public function test_get_user_by_email(): void
    {
        $user = new User(['email' => 'user@example.com']);

        $queryMock = Mockery::mock(Builder::class);
        $queryMock->shouldReceive('where')->once()->with('email', 'user@example.com')->andReturnSelf();
        $queryMock->shouldReceive('first')->once()->andReturn($user);

        $repo = Mockery::mock(UserEloquentRepository::class)->makePartial();
        $repo->shouldAllowMockingProtectedMethods();
        $repo->shouldReceive('query')->once()->andReturn($queryMock);

        $result = $repo->getUserByEmail('user@example.com');
        $this->assertEquals('user@example.com', $result->email);
    }

    public function test_update_user(): void
    {
        $user = Mockery::mock(User::class)->makePartial();
        $user->shouldReceive('save')->once();
        $user->email = 'old@example.com';
        $user->name = 'Old Name';

        $repo = Mockery::mock(UserEloquentRepository::class)->makePartial();
        $repo->shouldAllowMockingProtectedMethods();
        $repo->shouldReceive('getUserById')->once()->with(1)->andReturn($user);

        $updated = $repo->updateUser(1, 'new@example.com', 'New Name');

        $this->assertEquals('new@example.com', $updated->email);
        $this->assertEquals('New Name', $updated->name);
    }
}

