<?php

declare(strict_types=1);

namespace App\Client\usuarios\domain\Exception;

class UsuarioNotFoundException extends \DomainException
{
    public function __construct(string $message = 'Usuario no encontrado')
    {
        parent::__construct($message);
    }
} 