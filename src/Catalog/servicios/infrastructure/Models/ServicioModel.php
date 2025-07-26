<?php

namespace Src\Catalog\servicios\infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServicioModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'servicios';

    protected $fillable = [
        'nombre',
        'descripcion',
        'imagen_path',
        'precio_base',
        'duracion_minutos',
        'categoria_id',
        'especialidad_requerida_id',
        'activo',
    ];

    protected $casts = [
        'precio_base' => 'float',
        'duracion_minutos' => 'integer',
        'activo' => 'boolean',
        'categoria_id' => 'integer',
        'especialidad_requerida_id' => 'integer',
    ];
}