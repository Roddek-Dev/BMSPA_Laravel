<?php

declare(strict_types=1);

namespace Src\Client\usuarios\application\Profile\Command;

final class UpdateProfileCommand
{
    public function __construct(
        private int $userId,
        private ?string $nombre,
        private ?string $telefono,
        private ?string $imagenPath
    ) {}

    public function userId(): int
    {
        return $this->userId;
    }

    public function nombre(): ?string
    {
        return $this->nombre;
    }

    public function telefono(): ?string
    {
        return $this->telefono;
    }

    public function imagenPath(): ?string
    {
        return $this->imagenPath;
    }
}
