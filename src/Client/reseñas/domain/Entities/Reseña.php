<?php

namespace Src\Client\reseñas\domain\Entities;

final class Reseña
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $cliente_usuario_id,
        public readonly string $reseñable_type,
        public readonly int $reseñable_id,
        public readonly int $calificacion,
        public readonly ?string $comentario,
        public readonly bool $aprobada, // Corregido: de 'estado' a 'aprobada' (boolean)
        public readonly ?string $fecha_reseña // Añadido campo faltante
    ) {}
}