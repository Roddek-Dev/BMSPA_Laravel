<?php

declare(strict_types=1);

namespace Src\Admin\personal\domain\Exception;

use Exception;

class UsuarioYaEsEmpleadoException extends Exception
{
    public function __construct(string $message = "El usuario ya es empleado.")
    {
        parent::__construct($message);
    }
}
