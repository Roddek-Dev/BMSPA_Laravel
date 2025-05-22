<?php

declare(strict_types=1);

namespace App\Client\usuarios\infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UsuarioModel extends Model
{
    use HasFactory;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'telefono',
        'rol',
        'activo',
        'imagen_path',
        'musica_preferencia_navegacion_id',
        'sucursal_preferida_id'
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'musica_preferencia_navegacion_id' => 'integer',
        'sucursal_preferida_id' => 'integer'
    ];
} 