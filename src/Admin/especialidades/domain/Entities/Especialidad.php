<?php

namespace Src\Admin\especialidades\domain\Entities;

final class Especialidad
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $nombre,
        public readonly ?string $descripcion,
        public readonly ?string $icono_clave,
        public readonly bool $activo
    ) {}
}
