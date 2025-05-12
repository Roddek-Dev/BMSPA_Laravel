<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MusicaPreferenciaNavegacion extends Model
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