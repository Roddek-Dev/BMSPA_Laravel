<?php

namespace Src\Catalog\servicios\domain\Entities;

final class Servicio
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $nombre,
        public readonly ?string $descripcion,
        public readonly ?string $imagen_path,
        public readonly float $precio_base,
        public readonly int $duracion_minutos,
        public readonly ?int $categoria_id,
        public readonly ?int $especialidad_requerida_id,
        public readonly bool $activo
    ) {}
}