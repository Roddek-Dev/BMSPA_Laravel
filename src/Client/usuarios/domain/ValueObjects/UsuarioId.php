<?php

declare(strict_types=1);

namespace Src\Client\usuarios\domain\ValueObjects;

class UsuarioId
{
    private int $value;

    public function __construct(int $value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    private function validate(int $value): void
    {
        if ($value <= 0) {
            throw new \InvalidArgumentException('El ID debe ser un número positivo');
        }
    }

    public function value(): int
    {
        return $this->value;
    }

    public function equals(UsuarioId $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
} 