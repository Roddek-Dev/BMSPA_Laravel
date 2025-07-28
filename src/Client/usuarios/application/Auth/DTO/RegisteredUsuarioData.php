<?php

declare(strict_types=1);

namespace Src\Client\usuarios\application\Auth\DTO;

final class RegisteredUsuarioData
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $nombre,
        public readonly string $email,
        public readonly ?string $telefono,
        public readonly string $rol,
        public readonly bool $activo,
        public readonly ?string $imagen_path
    ) {
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
            'imagen_path' => $this->imagen_path,
        ];
    }
}