<?php

declare(strict_types=1);
namespace Src\Client\usuarios\domain\ValueObjects;

final class RolUsuario
{
    public const CLIENTE = 'CLIENTE';
    public const EMPLEADO = 'EMPLEADO';
    public const ADMIN_GENERAL = 'ADMIN_GENERAL';
    public const ADMIN_SUCURSAL = 'ADMIN_SUCURSAL';

    private string $value;

    public function __construct(string $value)
    {
        $this->ensureIsValidRol($value);
        $this->value = $value;
    }

    private function ensureIsValidRol(string $value): void
    {
        $validRoles = [
            self::CLIENTE,
            self::EMPLEADO,
            self::ADMIN_GENERAL,
            self::ADMIN_SUCURSAL
        ];

        if (!in_array($value, $validRoles)) {
            throw new \InvalidArgumentException(
                sprintf('<%s> no es un rol válido. Los roles válidos son: <%s>', 
                    $value, 
                    implode(', ', $validRoles)
                )
            );
        }
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(RolUsuario $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
} 