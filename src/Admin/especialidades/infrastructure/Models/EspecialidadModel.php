<?php

namespace Src\Admin\especialidades\infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\EspecialidadModelFactory;

class EspecialidadModel extends Model
{
    use HasFactory;

    protected $table = 'especialidades';

    // ¡CORRECCIÓN AQUÍ!
    protected $fillable = [
        'nombre',
        'descripcion',
        'activo', // Cambiado de 'activa' a 'activo'
    ];

    // ¡Y CORRECCIÓN AQUÍ!
    protected $casts = [
        'activo' => 'boolean', // Cambiado de 'activa' a 'activo'
    ];

    protected static function newFactory()
    {
        return EspecialidadModelFactory::new();
    }
}