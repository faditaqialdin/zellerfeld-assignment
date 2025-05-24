<?php

namespace App\Domain\Models;

use DateTimeImmutable;
use JsonSerializable;

readonly class Post implements JsonSerializable
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

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->userId,
            'content' => $this->content,
            'created_at' => $this->createdAt->format(DATE_ATOM),
        ];
    }
}
