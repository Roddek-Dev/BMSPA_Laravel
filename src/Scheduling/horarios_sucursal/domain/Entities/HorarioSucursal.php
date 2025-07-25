<?php

namespace Src\Scheduling\horarios_sucursal\domain\Entities;

final class HorarioSucursal
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $sucursal_id,
        public readonly int $dia_semana,
        public readonly ?string $hora_apertura,
        public readonly ?string $hora_cierre,
        public readonly bool $esta_cerrado_regularmente
    ) {}
}