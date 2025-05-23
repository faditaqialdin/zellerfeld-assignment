<?php

namespace App\Domain\Models;

use DateTimeImmutable;

readonly class Post
{
    public function __construct(
        private int               $id,
        private int               $userId,
        private string            $content,
        private DateTimeImmutable $createdAt,
    )
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
