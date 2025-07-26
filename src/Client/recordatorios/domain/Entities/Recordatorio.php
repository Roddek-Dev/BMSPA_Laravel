<?php

namespace Src\Client\recordatorios\domain\Entities;

final class Recordatorio
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $usuario_id,
        public readonly ?int $agendamiento_id,
        public readonly string $titulo,
        public readonly ?string $descripcion,
        public readonly string $fecha_hora_recordatorio,
        public readonly string $canal_notificacion,
        public readonly bool $enviado,
        public readonly ?string $fecha_envio,
        public readonly bool $activo,
        public readonly bool $fijado
    ) {}
}