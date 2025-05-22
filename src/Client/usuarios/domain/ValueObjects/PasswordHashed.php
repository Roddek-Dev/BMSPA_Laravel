<?php

declare(strict_types=1);

namespace Src\Client\usuarios\domain\ValueObjects;

class PasswordHashed
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
            throw new \InvalidArgumentException('La contraseña no puede estar vacía');
        }
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(PasswordHashed $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
} 