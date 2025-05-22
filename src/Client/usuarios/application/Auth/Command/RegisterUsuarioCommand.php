<?php

declare(strict_types=1);

namespace Src\Client\usuarios\application\Auth\Command;

final class RegisterUsuarioCommand
{
    private string $nombre;
    private string $email;
    private string $password;
    private ?string $telefono;

    public function __construct(
        string $nombre,
        string $email,
        string $password,
        ?string $telefono = null
    ) {
        $this->nombre = $nombre;
        $this->email = $email;
        $this->password = $password;
        $this->telefono = $telefono;
    }

    public function nombre(): string
    {
        return $this->nombre;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function telefono(): ?string
    {
        return $this->telefono;
    }
} 