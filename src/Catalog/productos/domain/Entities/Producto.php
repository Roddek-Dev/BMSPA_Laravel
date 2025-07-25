<?php

namespace Src\Catalog\productos\domain\Entities;

final class Producto
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $nombre,
        public readonly ?string $descripcion,
        public readonly ?string $imagen_path,
        public readonly float $precio,
        public readonly int $stock,
        public readonly ?string $sku,
        public readonly ?int $categoria_id,
        public readonly bool $activo
    ) {}
}