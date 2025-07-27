<?php

namespace Src\Client\ordenes\infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Src\Client\detalle_ordenes\infrastructure\Models\DetalleOrdenModel;

class OrdenModel extends Model
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
        'notas_orden',
    ];

    protected $casts = [
        'subtotal' => 'float',
        'descuento_total' => 'float',
        'impuestos_total' => 'float',
        'total_orden' => 'float',
        'fecha_orden' => 'datetime',
        'fecha_recibida' => 'datetime',
    ];

    /**
     * Define la relación: una orden tiene muchos detalles.
     */
    public function detalles()
    {
        return $this->hasMany(DetalleOrdenModel::class, 'orden_id');
    }
}