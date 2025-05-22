<?php

declare(strict_types=1);

namespace App\Client\usuarios\domain\ValueObjects;

class UsuarioId
{
    private int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
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