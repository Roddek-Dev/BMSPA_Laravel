<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleOrden extends Model
{
    use HasFactory;

    protected $table = 'detalle_ordenes';

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
        'precio_unitario_historico' => 'decimal:2',
        'subtotal_linea' => 'decimal:2',
    ];

    public function orden()
    {
        return $this->belongsTo(Orden::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}