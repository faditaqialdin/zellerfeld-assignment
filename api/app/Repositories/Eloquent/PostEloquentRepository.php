<?php

namespace App\Repositories\Eloquent;

use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class PostEloquentRepository
{
    public function getAllPostsPaginated(int $limit, int $page): LengthAwarePaginator
    {
        return $this->query()->latest()->paginate(perPage: $limit, page: $page);
    }

    protected function query(): Builder
    {
        return Post::query();
    }

    public function getUserPostsPaginated(int $userId, int $limit, int $page): LengthAwarePaginator
    {
        return $this->query()->where('user_id', $userId)->latest()->paginate(perPage: $limit, page: $page);
    }

    public function createUserPost($userId, $content): Post
    {
        return $this->query()->create([
            'user_id' => $userId,
            'content' => $content,
        ]);
    }
}
