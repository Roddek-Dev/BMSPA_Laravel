<?php

declare(strict_types=1);

namespace Src\Client\usuarios\application\Auth\DTO;

final class RegisteredUsuarioData
{
    public function __construct(
        private int $id,
        private string $nombre,
        private string $email
    ) {}

    public function id(): int
    {
        return $this->id;
    }

    public function nombre(): string
    {
        return $this->nombre;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'email' => $this->email
        ];
    }
} 