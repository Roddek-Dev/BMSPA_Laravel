<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ServicioSucursal extends Pivot
{
    use HasFactory;

    protected $table = 'servicio_sucursal';

    protected $fillable = [
        'servicio_id',
        'sucursal_id',
        'precio_en_sucursal',
        'esta_disponible',
    ];

    protected $casts = [
        'precio_en_sucursal' => 'decimal:2',
        'esta_disponible' => 'boolean',
    ];

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }
}