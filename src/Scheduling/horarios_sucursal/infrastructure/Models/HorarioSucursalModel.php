<?php

namespace Src\Scheduling\horarios_sucursal\infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorarioSucursalModel extends Model
{
    use HasFactory;

    protected $table = 'horarios_sucursal';

    protected $fillable = [
        'sucursal_id',
        'dia_semana',
        'hora_apertura',
        'hora_cierre',
        'esta_cerrado_regularmente',
    ];

    protected $casts = [
        'esta_cerrado_regularmente' => 'boolean',
    ];
}