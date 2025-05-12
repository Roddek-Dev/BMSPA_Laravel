<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorarioSucursal extends Model
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
        'hora_apertura' => 'string', // Considerar 'datetime' si se almacena con fecha
        'hora_cierre' => 'string', // Considerar 'datetime' si se almacena con fecha
        'dia_semana' => 'integer',
    ];

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }
}