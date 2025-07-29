<?php

declare(strict_types=1);

namespace Src\Payments\transacciones_pago\domain\Entities;

final class TransaccionPago
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $orden_id,
        public readonly string $mercadopago_payment_id,
        public readonly string $mercadopago_preference_id,
        public readonly string $payment_method_id,
        public readonly float $amount,
        public readonly string $currency,
        public readonly string $status,
        public readonly ?string $status_detail,
        public readonly string $fecha_transaccion
    ) {}
}
