<?php

namespace Src\Client\detalle_ordenes\infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\Client\ordenes\infrastructure\Models\OrdenModel;

class DetalleOrdenModel extends Model
{
    use HasFactory;

    protected $table = 'detalle_ordenes';

    // La tabla de detalles no tiene timestamps por defecto en tu esquema.
    public $timestamps = false;

    protected $fillable = [
        'orden_id',
        'producto_id',
        'nombre_producto_historico',
        'cantidad',
        'precio_unitario_historico',
        'subtotal_linea',
    ];

    protected $casts = [
        'cantidad' => 'integer',
        'precio_unitario_historico' => 'float',
        'subtotal_linea' => 'float',
    ];

    /**
     * Define la relación inversa: un detalle pertenece a una orden.
     */
    public function orden()
    {
        return $this->belongsTo(OrdenModel::class, 'orden_id');
    }
}