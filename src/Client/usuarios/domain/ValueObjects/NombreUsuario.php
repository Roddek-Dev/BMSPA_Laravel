<?php

declare(strict_types=1);

namespace App\Client\usuarios\domain\ValueObjects;

use InvalidArgumentException;

class NombreUsuario
{
    private string $value;

    public function __construct(string $value)
    {
        $this->ensureIsValidNombre($value);
        $this->value = $value;
    }

    private function ensureIsValidNombre(string $nombre): void
    {
        if (empty(trim($nombre))) {
            throw new InvalidArgumentException('El nombre no puede estar vacío');
        }

        if (strlen($nombre) > 255) {
            throw new InvalidArgumentException('El nombre no puede tener más de 255 caracteres');
        }

        if (!preg_match('/^[\p{L}\s]+$/u', $nombre)) {
            throw new InvalidArgumentException('El nombre solo puede contener letras y espacios');
        }
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(NombreUsuario $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
} 