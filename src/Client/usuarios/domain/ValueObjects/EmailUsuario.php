<?php

declare(strict_types=1);

namespace Src\Client\usuarios\domain\ValueObjects;

use InvalidArgumentException;

class EmailUsuario
{
    private string $value;

    public function __construct(string $value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    private function validate(string $value): void
    {
        if (empty($value)) {
            throw new \InvalidArgumentException('El email no puede estar vacío');
        }

        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('El email no es válido');
        }

        if (strlen($value) > 255) {
            throw new \InvalidArgumentException('El email no puede tener más de 255 caracteres');
        }
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(EmailUsuario $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
} 