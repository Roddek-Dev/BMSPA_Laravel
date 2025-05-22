<?php

declare(strict_types=1);

namespace App\Client\usuarios\domain\Exception;

class InvalidCredentialsException extends \DomainException
{
    public function __construct(string $message = 'Credenciales inválidas')
    {
        parent::__construct($message);
    }
} 