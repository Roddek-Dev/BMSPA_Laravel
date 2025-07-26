<?php

namespace Src\Scheduling\agendamientos\domain\Entities;

final class Agendamiento
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $cliente_usuario_id,
        public readonly ?int $personal_id,
        public readonly int $servicio_id,
        public readonly int $sucursal_id,
        public readonly string $fecha_hora_inicio,
        public readonly string $fecha_hora_fin,
        public readonly float $precio_final,
        public readonly string $estado,
        public readonly ?string $notas_cliente,
        public readonly ?string $notas_internas
    ) {}
}