<?php

namespace Src\Client\musica_preferencias_navegacion\domain\Entities;

final class MusicaPreferenciaNavegacion
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $nombre_opcion,
        public readonly ?string $descripcion,
        public readonly ?string $stream_url_ejemplo,
        public readonly bool $activo
    ) {}
}