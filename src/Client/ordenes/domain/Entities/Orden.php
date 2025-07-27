<?php

namespace Src\Client\ordenes\domain\Entities;

final class Orden
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $cliente_usuario_id,
        public readonly string $numero_orden,
        public readonly string $fecha_orden,
        public readonly ?string $fecha_recibida,
        public readonly float $subtotal,
        public readonly float $descuento_total,
        public readonly float $impuestos_total,
        public readonly float $total_orden,
        public readonly string $estado_orden,
        public readonly ?string $notas_orden
    ) {}
}