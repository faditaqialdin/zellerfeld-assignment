<?php

namespace Tests\Unit\Repositories\Domain;

use App\Models\Post;
use App\Repositories\Domain\PostDomainRepository;
use App\Repositories\Eloquent\PostEloquentRepository;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class PostDomainRepositoryTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function test_returns_paginated_posts(): void
    {
        $paginatorMock = new LengthAwarePaginator(
            items: [
                $this->mockPost(1, 1, 'Content 1'),
                $this->mockPost(2, 2, 'Content 2'),
            ],
            total: 2,
            perPage: 2,
            currentPage: 1,
        );
        $postEloquentRepositoryMock = $this->createMock(PostEloquentRepository::class);
        $postEloquentRepositoryMock
            ->method('getAllPostsPaginated')
            ->with(2, 1)
            ->willReturn($paginatorMock);

        $postDomainRepository = new PostDomainRepository($postEloquentRepositoryMock);
        $paginator = $postDomainRepository->getAllPostsPaginated(2, 1);

        $this->assertInstanceOf(LengthAwarePaginatorContract::class, $paginator);
        $this->assertEquals(2, $paginator->total());
        $this->assertEquals(2, $paginator->perPage());
        $this->assertEquals(1, $paginator->items()[0]->getId());
        $this->assertEquals('Content 1', $paginator->items()[0]->getContent());
    }

    private function mockPost(int $id, int $user_id, string $content): Mockery\LegacyMockInterface|(Mockery\MockInterface&Post)
    {
        $post = Mockery::mock(Post::class)->makePartial();
        $post->expects('getAttribute')->with('id')->andReturn($id);
        $post->expects('getAttribute')->with('user_id')->andReturn($user_id);
        $post->expects('getAttribute')->with('content')->andReturn($content);
        $post->expects('getAttribute')->with('created_at')->andReturn(Carbon::now());
        return $post;
    }

    /**
     * @throws Exception
     */
    public function test_returns_paginated_user_posts(): void
    {
        $post_id = 1;
        $content = 'Content 1';
        $user_id = 1;
        $paginatorMock = new LengthAwarePaginator(
            items: [
                $this->mockPost($post_id, $user_id, $content),
            ],
            total: 1,
            perPage: 1,
            currentPage: 1,
        );
        $postEloquentRepositoryMock = $this->createMock(PostEloquentRepository::class);
        $postEloquentRepositoryMock
            ->method('getUserPostsPaginated')
            ->with($user_id, 2, 1)
            ->willReturn($paginatorMock);

        $postDomainRepository = new PostDomainRepository($postEloquentRepositoryMock);
        $paginator = $postDomainRepository->getUserPostsPaginated($user_id, 2, 1);

        $this->assertInstanceOf(LengthAwarePaginatorContract::class, $paginator);
        $this->assertCount(1, $paginator->items());
        $this->assertTrue(collect($paginator->items())->every(fn($post) => $post->getUserId() === $user_id));
    }

    /**
     * @throws Exception
     */
    public function test_creates_user_post(): void
    {
        $post_id = 1;
        $user_id = 2;
        $content = 'New post content';
        $postEloquentRepositoryMock = $this->createMock(PostEloquentRepository::class);
        $postEloquentRepositoryMock
            ->method('createUserPost')
            ->with($user_id, $content)
            ->willReturn($this->mockPost($post_id, $user_id, $content));

        $postDomainRepository = new PostDomainRepository($postEloquentRepositoryMock);
        $domainPost = $postDomainRepository->createUserPost($user_id, $content);

        $this->assertEquals($post_id, $domainPost->getId());
        $this->assertEquals($user_id, $domainPost->getUserId());
        $this->assertEquals($content, $domainPost->getContent());
    }
}
