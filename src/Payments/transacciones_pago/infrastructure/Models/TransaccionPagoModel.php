<?php

declare(strict_types=1);

namespace Src\Payments\transacciones_pago\infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\Client\ordenes\infrastructure\Models\OrdenModel;

class TransaccionPagoModel extends Model
{
    use HasFactory;

    protected $table = 'transacciones_pago';

    protected $fillable = [
        'orden_id',
        'mercadopago_payment_id',
        'mercadopago_preference_id',
        'payment_method_id',
        'amount',
        'currency',
        'status',
        'status_detail',
        'fecha_transaccion',
    ];

    protected $casts = [
        'amount' => 'float',
        'fecha_transaccion' => 'datetime',
    ];

    /**
     * Define la relación: una transacción pertenece a una orden.
     */
    public function orden()
    {
        return $this->belongsTo(OrdenModel::class, 'orden_id');
    }
}
