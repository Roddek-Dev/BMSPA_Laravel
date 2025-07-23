<?php

namespace Src\Admin\categorias\domain\Entities;

final class Categoria
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $nombre,
        public readonly ?string $descripcion,
        public readonly string $tipo_categoria,
        public readonly ?string $icono_clave,
        public readonly bool $activo
    ) {}
}