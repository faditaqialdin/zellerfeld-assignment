<?php

namespace App\Domain\Models;

use DateTimeImmutable;
use JsonSerializable;

readonly class User implements JsonSerializable
{
    public function __construct(
        private int               $id,
        private string            $name,
        private string            $email,
        private DateTimeImmutable $createdAt,
    )
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->name,
            'created_at' => $this->createdAt->format(DATE_ATOM),
        ];
    }
}
