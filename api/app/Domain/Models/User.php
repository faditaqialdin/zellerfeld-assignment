<?php

namespace App\Domain\Models;

use DateTimeImmutable;

readonly class User
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
}
