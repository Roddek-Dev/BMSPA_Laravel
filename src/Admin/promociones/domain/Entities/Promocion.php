<?php

namespace Src\Admin\promociones\domain\Entities;

final class Promocion
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $codigo,
        public readonly string $nombre,
        public readonly ?string $descripcion,
        public readonly string $tipo_descuento,
        public readonly float $valor_descuento,
        public readonly string $fecha_inicio,
        public readonly ?string $fecha_fin,
        public readonly ?int $usos_maximos_total,
        public readonly ?int $usos_maximos_por_cliente,
        public readonly int $usos_actuales,
        public readonly bool $activo,
        public readonly bool $aplica_a_todos_productos,
        public readonly bool $aplica_a_todos_servicios
    ) {}
}