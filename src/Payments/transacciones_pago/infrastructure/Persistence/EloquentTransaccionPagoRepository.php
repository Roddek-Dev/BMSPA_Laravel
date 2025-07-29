<?php

declare(strict_types=1);

namespace Src\Payments\transacciones_pago\infrastructure\Persistence;

use Src\Payments\transacciones_pago\domain\Repositories\TransaccionPagoRepository;
use Src\Payments\transacciones_pago\domain\Entities\TransaccionPago;
use Src\Payments\transacciones_pago\infrastructure\Models\TransaccionPagoModel;

class EloquentTransaccionPagoRepository implements TransaccionPagoRepository
{
    public function save(TransaccionPago $transaccion): TransaccionPago
    {
        $model = TransaccionPagoModel::create($this->toArray($transaccion));
        return $this->toEntity($model);
    }

    public function findByOrdenId(int $ordenId): ?TransaccionPago
    {
        $model = TransaccionPagoModel::where('orden_id', $ordenId)->first();
        return $model ? $this->toEntity($model) : null;
    }

    public function findByMercadoPagoPaymentId(string $paymentId): ?TransaccionPago
    {
        $model = TransaccionPagoModel::where('mercadopago_payment_id', $paymentId)->first();
        return $model ? $this->toEntity($model) : null;
    }

    private function toEntity(TransaccionPagoModel $model): TransaccionPago
    {
        return new TransaccionPago(
            $model->id,
            $model->orden_id,
            $model->mercadopago_payment_id,
            $model->mercadopago_preference_id,
            $model->payment_method_id,
            $model->amount,
            $model->currency,
            $model->status,
            $model->status_detail,
            $model->fecha_transaccion->toDateTimeString()
        );
    }

    private function toArray(TransaccionPago $transaccion): array
    {
        return [
            'orden_id' => $transaccion->orden_id,
            'mercadopago_payment_id' => $transaccion->mercadopago_payment_id,
            'mercadopago_preference_id' => $transaccion->mercadopago_preference_id,
            'payment_method_id' => $transaccion->payment_method_id,
            'amount' => $transaccion->amount,
            'currency' => $transaccion->currency,
            'status' => $transaccion->status,
            'status_detail' => $transaccion->status_detail,
            'fecha_transaccion' => $transaccion->fecha_transaccion,
        ];
    }
}
