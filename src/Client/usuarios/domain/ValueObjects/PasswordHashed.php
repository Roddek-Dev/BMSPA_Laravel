<?php

declare(strict_types=1);

namespace App\Client\usuarios\domain\ValueObjects;

class PasswordHashed
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
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