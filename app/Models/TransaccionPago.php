<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaccionPago extends Model
{
    use HasFactory;

    protected $table = 'transacciones_pago';

    protected $fillable = [
        'orden_id',
        'agendamiento_id',
        'cliente_usuario_id',
        'monto',
        'moneda',
        'metodo_pago',
        'id_transaccion_pasarela',
        'estado_pago',
        'fecha_transaccion',
        'datos_pasarela_request',
        'datos_pasarela_response',
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'fecha_transaccion' => 'datetime',
        'datos_pasarela_request' => 'json',
        'datos_pasarela_response' => 'json',
    ];

    public function orden()
    {
        return $this->belongsTo(Orden::class);
    }

    public function agendamiento()
    {
        return $this->belongsTo(Agendamiento::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Usuario::class, 'cliente_usuario_id');
    }
}