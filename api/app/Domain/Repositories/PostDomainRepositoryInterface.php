<?php

namespace App\Domain\Repositories;

use App\Domain\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PostDomainRepositoryInterface
{
    /** @return LengthAwarePaginator<Post> */
    public function getAllPostsPaginated(int $limit, int $page): LengthAwarePaginator;

    /** @return LengthAwarePaginator<Post> */
    public function getUserPostsPaginated(int $userId, int $limit, int $page): LengthAwarePaginator;

    public function createUserPost(int $userId, string $content): Post;
}
