<?php

namespace App\Repositories\Domain;

use App\Domain\Models\Post as DomainPost;
use App\Domain\Repositories\PostDomainRepositoryInterface;
use App\Models\Post;
use App\Repositories\Eloquent\PostEloquentRepository;
use Illuminate\Pagination\LengthAwarePaginator;

readonly class PostDomainRepository implements PostDomainRepositoryInterface
{
    public function __construct(private PostEloquentRepository $postEloquentRepository)
    {
    }

    public function getAllPostsPaginated(int $limit, int $page): LengthAwarePaginator
    {
        $paginator = $this->postEloquentRepository->getAllPostsPaginated($limit, $page);
        return $paginator->setCollection(
            $paginator->getCollection()->map(
                fn(Post $post) => $this->domainPostFromEloquentPost($post)
            )
        );
    }

    protected function domainPostFromEloquentPost(Post $post): DomainPost
    {
        return new DomainPost(
            id: $post->id,
            userId: $post->user_id,
            content: $post->content,
            createdAt: $post->created_at->toDateTimeImmutable(),
        );
    }

    public function getUserPostsPaginated(int $userId, int $limit, int $page): LengthAwarePaginator
    {
        $posts = $this->postEloquentRepository->getUserPostsPaginated($userId, $limit, $page);
        return $posts->setCollection(
            $posts->getCollection()->map(
                fn(Post $post) => $this->domainPostFromEloquentPost($post)
            )
        );
    }

    public function createUserPost($userId, $content): DomainPost
    {
        $post = $this->postEloquentRepository->createUserPost($userId, $content);
        return $this->domainPostFromEloquentPost($post);
    }
}
