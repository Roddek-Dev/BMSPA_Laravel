<?php

namespace Src\Admin\especialidades\infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    use HasFactory;

    protected $table = 'especialidades';

    protected $fillable = [
        'nombre',
        'descripcion',
        'icono_clave',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];
}