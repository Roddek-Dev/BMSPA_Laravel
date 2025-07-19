<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orden extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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

    /**
     * Obtiene la dirección de envío para la orden.
     */
    public function direccionEnvio()
    {
        return $this->morphOne(Direccion::class, 'direccionable');
    }

    /**
     * Relación con el usuario que realizó la orden.
     */
    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_usuario_id');
    }
}