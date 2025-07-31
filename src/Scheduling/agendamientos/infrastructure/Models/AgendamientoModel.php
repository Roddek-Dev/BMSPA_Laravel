<?php

namespace Src\Scheduling\agendamientos\infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AgendamientoModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'agendamientos';

    protected $fillable = [
        'cliente_usuario_id',
        'personal_id',
        'servicio_id',
        'sucursal_id',
        'fecha_hora_inicio',
        'fecha_hora_fin',
        'precio_final',
        'estado',
        'notas_cliente',
        'notas_internas',
    ];

    protected $casts = [
        'precio_final' => 'float',
        'fecha_hora_inicio' => 'datetime',
        'fecha_hora_fin' => 'datetime',
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */

    protected static function newFactory()
    {
        // Le indica a Laravel que use este Factory específico
        return \Database\Factories\AgendamientoModelFactory::new();    
    }
}