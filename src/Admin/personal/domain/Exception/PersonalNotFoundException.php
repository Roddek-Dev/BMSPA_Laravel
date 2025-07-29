<?php

declare(strict_types=1);

namespace Src\Admin\personal\domain\Exception;

use Exception;

class PersonalNotFoundException extends Exception
{
    public function __construct(string $message = "Personal no encontrado.")
    {
        parent::__construct($message);
    }
}
