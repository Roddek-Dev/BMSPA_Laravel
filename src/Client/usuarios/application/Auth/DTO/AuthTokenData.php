<?php

declare(strict_types=1);

namespace App\Client\usuarios\application\Auth\DTO;

final class AuthTokenData
{
    public function __construct(
        private string $token,
        private string $type,
        private int $expires_in
    ) {}

    public function token(): string
    {
        return $this->token;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function expiresIn(): int
    {
        return $this->expires_in;
    }

    public function toArray(): array
    {
        return [
            'token' => $this->token,
            'type' => $this->type,
            'expires_in' => $this->expires_in
        ];
    }
} 