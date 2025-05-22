<?php

declare(strict_types=1);

namespace App\Client\usuarios\domain\ValueObjects;

use InvalidArgumentException;

class EmailUsuario
{
    private string $value;

    public function __construct(string $value)
    {
        $this->ensureIsValidEmail($value);
        $this->value = $value;
    }

    private function ensureIsValidEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(
                sprintf('<%s> no es un email válido', $email)
            );
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