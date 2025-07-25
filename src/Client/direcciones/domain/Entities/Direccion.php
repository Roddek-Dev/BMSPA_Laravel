<?php

namespace Src\Client\direcciones\domain\Entities;

// SIN NINGUNA ANOTACIÓN DE SWAGGER AQUÍ.

final class Direccion
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $direccionable_id,
        public readonly string $direccionable_type,
        public readonly string $direccion,
        public readonly string $colonia,
        public readonly string $codigo_postal,
        public readonly string $ciudad,
        public readonly string $estado,
        public readonly ?string $referencias,
        public readonly bool $es_predeterminada
    ) {}
}