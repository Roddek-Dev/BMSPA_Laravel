<?php

namespace Src\Admin\personal\domain\Entities;

final class Personal
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $usuario_id,
        public readonly ?int $sucursal_asignada_id,
        public readonly string $tipo_personal,
        public readonly ?string $numero_empleado,
        public readonly ?string $fecha_contratacion,
        public readonly bool $activo_en_empresa
    ) {}
}