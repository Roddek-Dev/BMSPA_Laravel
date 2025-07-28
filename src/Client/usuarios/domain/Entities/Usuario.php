<?php

declare(strict_types=1);

namespace Src\Client\usuarios\domain\Entities;

use Src\Client\usuarios\domain\ValueObjects\UsuarioId;
use Src\Client\usuarios\domain\ValueObjects\NombreUsuario;
use Src\Client\usuarios\domain\ValueObjects\EmailUsuario;
use Src\Client\usuarios\domain\ValueObjects\PasswordHashed;

class Usuario
{
    private ?UsuarioId $id;
    private NombreUsuario $nombre;
    private EmailUsuario $email;
    private PasswordHashed $password;
    private ?string $telefono;
    private string $rol;
    private bool $activo;
    private ?string $imagen_path;

    public function __construct(
        ?UsuarioId $id,
        NombreUsuario $nombre,
        EmailUsuario $email,
        PasswordHashed $password,
        ?string $telefono = null,
        string $rol = 'CLIENTE',
        bool $activo = true,
        ?string $imagen_path = null
    ) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->password = $password;
        $this->telefono = $telefono;
        $this->rol = $rol;
        $this->activo = $activo;
        $this->imagen_path = $imagen_path;
    }

    public function id(): ?UsuarioId
    {
        return $this->id;
    }

    public function nombre(): NombreUsuario
    {
        return $this->nombre;
    }

    public function email(): EmailUsuario
    {
        return $this->email;
    }

    public function password(): PasswordHashed
    {
        return $this->password;
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
        return $this->imagen_path;
    }

    public function actualizarPerfil(
        ?string $nombre = null,
        ?string $telefono = null,
        ?string $imagen_path = null
    ): void {
        if ($nombre !== null) {
            $this->nombre = new NombreUsuario($nombre);
        }
        if ($telefono !== null) {
            $this->telefono = $telefono;
        }
        if ($imagen_path !== null) {
            $this->imagen_path = $imagen_path;
        }
    }

    public function cambiarPassword(PasswordHashed $nuevaPassword): void
    {
        $this->password = $nuevaPassword;
    }

    public function desactivar(): void
    {
        $this->activo = false;
    }

    public function activar(): void
    {
        $this->activo = true;
    }
}