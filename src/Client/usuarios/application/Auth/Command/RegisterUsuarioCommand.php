<?php

declare(strict_types=1);

namespace Src\Client\usuarios\application\Auth\Command;

class RegisterUsuarioCommand
{
    public function __construct(
        private readonly string $nombre,
        private readonly string $email,
        private readonly string $password,
        private readonly ?string $telefono = null,
        private readonly ?string $imagen_path = null
    ) {
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function getImagenPath(): ?string
    {
        return $this->imagen_path;
    }
}