<?php

namespace Tests\Unit\Repositories\Eloquent;

use App\Models\Post;
use App\Repositories\Eloquent\PostEloquentRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery;
use Tests\TestCase;

class PostEloquentRepositoryTest extends TestCase
{
    public function test_get_all_posts_paginated(): void
    {
        $postId = 1;
        $content = 'Hello';
        $perPage = 10;
        $page = 1;
        $total = 1;

        $paginator = new LengthAwarePaginator(
            collect([new Post(['id' => $postId, 'content' => $content])]),
            $total,
            $perPage,
            $page,
        );
        $postQuery = Mockery::mock(Builder::class);
        $postQuery->shouldReceive('latest')->once()->andReturnSelf();
        $postQuery->shouldReceive('paginate')->once()
            ->with($perPage, ['*'], 'page', $page)->andReturn($paginator);

        $repository = Mockery::mock(PostEloquentRepository::class)->makePartial();
        $repository->shouldAllowMockingProtectedMethods();
        $repository->shouldReceive('query')->once()->andReturn($postQuery);

        $result = $repository->getAllPostsPaginated($perPage, $page);

        $this->assertInstanceOf(LengthAwarePaginatorContract::class, $result);
        $this->assertEquals($total, $result->total());
        $this->assertEquals($postId, $result->items()[0]->id);
        $this->assertEquals($content, $result->items()[0]->content);
    }

    public function test_get_user_posts_paginated(): void
    {
        $postId = 2;
        $content = 'Hello';
        $userId = 42;
        $perPage = 5;
        $page = 1;
        $total = 1;

        $paginator = new LengthAwarePaginator(
            collect([new Post(['id' => $postId, 'user_id' => $userId, 'content' => $content])]),
            $total,
            $perPage,
            $page
        );

        $postQuery = Mockery::mock(Builder::class);
        $postQuery->shouldReceive('where')->with('user_id', $userId)->once()->andReturnSelf();
        $postQuery->shouldReceive('latest')->once()->andReturnSelf();
        $postQuery->shouldReceive('paginate')->once()
            ->with($perPage, ['*'], 'page', $page)->andReturn($paginator);

        $repository = Mockery::mock(PostEloquentRepository::class)->makePartial();
        $repository->shouldAllowMockingProtectedMethods();
        $repository->shouldReceive('query')->once()->andReturn($postQuery);

        $result = $repository->getUserPostsPaginated($userId, $perPage, $page);

        $this->assertInstanceOf(LengthAwarePaginatorContract::class, $result);
        $this->assertEquals($total, $result->total());
        $this->assertEquals($postId, $result->items()[0]->id);
        $this->assertEquals($userId, $result->items()[0]->user_id);
        $this->assertEquals($content, $result->items()[0]->content);
    }

    public function test_create_user_post(): void
    {
        $userId = 1;
        $content = 'Test content';

        $expectedPost = new Post(['user_id' => $userId, 'content' => $content]);

        $postQuery = Mockery::mock(Builder::class);
        $postQuery->shouldReceive('create')
            ->with(['user_id' => $userId, 'content' => $content])
            ->once()
            ->andReturn($expectedPost);

        $repository = Mockery::mock(PostEloquentRepository::class)->makePartial();
        $repository->shouldAllowMockingProtectedMethods();
        $repository->shouldReceive('query')->once()->andReturn($postQuery);

        $result = $repository->createUserPost($userId, $content);

        $this->assertEquals($userId, $result->user_id);
        $this->assertEquals($content, $result->content);
    }
}
