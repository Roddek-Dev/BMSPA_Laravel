<?php

namespace Src\Client\musica_preferencias_navegacion\infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MusicaPreferenciaNavegacionModel extends Model
{
    use HasFactory;

    protected $table = 'musica_preferencias_navegacion';

    protected $fillable = [
        'nombre_opcion',
        'descripcion',
        'stream_url_ejemplo',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];
}