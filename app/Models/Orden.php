<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orden extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ordenes';

    protected $fillable = [
        'cliente_usuario_id',
        'numero_orden',
        'fecha_orden',
        'fecha_recibida',
        'subtotal',
        'descuento_total',
        'impuestos_total',
        'total_orden',
        'estado_orden',
        'direccion_envio_calle',
        'direccion_envio_numero_exterior',
        'direccion_envio_numero_interior',
        'direccion_envio_colonia',
        'direccion_envio_codigo_postal',
        'direccion_envio_municipio_alcaldia',
        'direccion_envio_ciudad',
        'direccion_envio_estado',
        'notas_orden',
    ];

    protected $casts = [
        'fecha_orden' => 'datetime',
        'fecha_recibida' => 'datetime',
        'subtotal' => 'decimal:2',
        'descuento_total' => 'decimal:2',
        'impuestos_total' => 'decimal:2',
        'total_orden' => 'decimal:2',
    ];

    public function cliente()
    {
        return $this->belongsTo(Usuario::class, 'cliente_usuario_id');
    }
}