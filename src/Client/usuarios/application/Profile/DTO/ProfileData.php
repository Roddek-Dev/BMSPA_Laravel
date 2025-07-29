<?php

declare(strict_types=1);

namespace Src\Client\usuarios\application\Profile\DTO;

final class ProfileData
{
    public function __construct(
        private int $id,
        private string $nombre,
        private string $email,
        private ?string $telefono,
        private string $rol,
        private bool $activo,
        private ?string $imagenPath,
        private string $createdAt,
        private string $updatedAt
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

    public function telefono(): ?string
    {
        return $this->telefono;
    }

    public function rol(): string
    {
        return $this->rol;
    }

    public function activo(): bool
    {
        return $this->activo;
    }

    public function imagenPath(): ?string
    {
        return $this->imagenPath;
    }

    public function createdAt(): string
    {
        return $this->createdAt;
    }

    public function updatedAt(): string
    {
        return $this->updatedAt;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'email' => $this->email,
            'telefono' => $this->telefono,
            'rol' => $this->rol,
            'activo' => $this->activo,
            'imagen_path' => $this->imagenPath,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt
        ];
    }
}
