<?php

declare(strict_types=1);

namespace Src\Scheduling\agendamientos\domain\Exception;

use Exception;

class ConflictHorarioException extends Exception
{
    public function __construct(string $message = "El horario seleccionado ya no está disponible.")
    {
        parent::__construct($message);
    }
}
