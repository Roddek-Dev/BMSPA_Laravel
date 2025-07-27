<?php

namespace Src\Client\detalle_ordenes\domain\Entities;

final class DetalleOrden
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $orden_id,
        public readonly int $producto_id,
        public readonly string $nombre_producto_historico,
        public readonly int $cantidad,
        public readonly float $precio_unitario_historico,
        public readonly float $subtotal_linea
    ) {}
}