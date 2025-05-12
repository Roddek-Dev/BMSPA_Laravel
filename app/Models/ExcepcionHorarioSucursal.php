<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExcepcionHorarioSucursal extends Model
{
    use HasFactory;

    protected $table = 'excepciones_horario_sucursal';

    protected $fillable = [
        'sucursal_id',
        'fecha',
        'esta_cerrado',
        'hora_apertura',
        'hora_cierre',
        'descripcion',
    ];

    protected $casts = [
        'fecha' => 'date',
        'esta_cerrado' => 'boolean',
        'hora_apertura' => 'string', // Considerar 'datetime' si se almacena con fecha
        'hora_cierre' => 'string',   // Considerar 'datetime' si se almacena con fecha
    ];

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }
}