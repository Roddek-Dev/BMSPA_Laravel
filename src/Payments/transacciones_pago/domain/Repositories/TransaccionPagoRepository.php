<?php

declare(strict_types=1);

namespace Src\Payments\transacciones_pago\domain\Repositories;

use Src\Payments\transacciones_pago\domain\Entities\TransaccionPago;

interface TransaccionPagoRepository
{
    public function save(TransaccionPago $transaccion): TransaccionPago;
    public function findByOrdenId(int $ordenId): ?TransaccionPago;
    public function findByMercadoPagoPaymentId(string $paymentId): ?TransaccionPago;
}
