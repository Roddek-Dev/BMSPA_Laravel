<?php

namespace Src\Admin\sucursales\domain\Entities;

final class Sucursal
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $nombre,
        public readonly ?string $imagen_path,
        public readonly ?string $telefono_contacto,
        public readonly ?string $email_contacto,
        public readonly ?string $link_maps,
        public readonly ?float $latitud,
        public readonly ?float $longitud,
        public readonly bool $activo
    ) {}
}
