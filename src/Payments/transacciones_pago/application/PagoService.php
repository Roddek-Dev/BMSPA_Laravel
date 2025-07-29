<?php

declare(strict_types=1);

namespace Src\Payments\transacciones_pago\application;

use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\MercadoPagoConfig;
use Src\Payments\transacciones_pago\domain\Repositories\TransaccionPagoRepository;
use Src\Payments\transacciones_pago\domain\Entities\TransaccionPago;
use Src\Client\ordenes\infrastructure\Models\OrdenModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PagoService
{
    private PreferenceClient $preferenceClient;

    public function __construct(
        private readonly TransaccionPagoRepository $repository
    ) {
        // Configurar Mercado Pago
        MercadoPagoConfig::setAccessToken(config('services.mercadopago.access_token'));
        $this->preferenceClient = new PreferenceClient();
    }

    /**
     * Crea una preferencia de pago en Mercado Pago
     */
    public function crearPreferenciaPago(OrdenModel $orden): array
    {
        // Crear items para Mercado Pago
        $items = [];
        foreach ($orden->detalles as $detalle) {
            $items[] = [
                'id' => $detalle->producto_id,
                'title' => $detalle->nombre_producto_historico,
                'quantity' => $detalle->cantidad,
                'unit_price' => $detalle->precio_unitario_historico,
                'currency_id' => 'MXN'
            ];
        }

        // Configurar preferencia
        $preference = [
            'items' => $items,
            'external_reference' => (string) $orden->id, // Para vincular con nuestra orden
            'back_urls' => [
                'success' => config('app.frontend_url') . '/payment/success',
                'failure' => config('app.frontend_url') . '/payment/failure',
                'pending' => config('app.frontend_url') . '/payment/pending'
            ],
            'notification_url' => config('app.url') . '/api/webhooks/mercadopago-ipn',
            'auto_return' => 'approved'
        ];

        // Crear preferencia en Mercado Pago
        $response = $this->preferenceClient->create($preference);

        return [
            'preference_id' => $response->id,
            'init_point' => $response->init_point,
            'sandbox_init_point' => $response->sandbox_init_point
        ];
    }

    /**
     * Procesa la notificación de pago de Mercado Pago
     */
    public function procesarNotificacionPago(string $paymentId): bool
    {
        try {
            // Obtener información del pago desde Mercado Pago
            $paymentClient = new PaymentClient();
            $payment = $paymentClient->get($paymentId);

            // Verificar que el pago fue aprobado
            if ($payment->status !== 'approved') {
                return false;
            }

            // Obtener el ID de la orden desde external_reference
            $ordenId = (int) $payment->external_reference;
            $orden = OrdenModel::find($ordenId);

            if (!$orden) {
                return false;
            }

            // Verificar que no existe ya una transacción para esta orden
            $transaccionExistente = $this->repository->findByOrdenId($ordenId);
            if ($transaccionExistente) {
                return true; // Ya procesado
            }

            // Crear transacción de pago
            $transaccion = new TransaccionPago(
                null,
                $ordenId,
                (string) $payment->id,
                (string) ($payment->preference_id ?? ''),
                (string) $payment->payment_method_id,
                (float) $payment->transaction_amount,
                (string) $payment->currency_id,
                (string) $payment->status,
                $payment->status_detail,
                Carbon::now()->toDateTimeString()
            );

            $this->repository->save($transaccion);

            // Actualizar estado de la orden
            $orden->estado_orden = 'PAGADA';
            $orden->save();

            // TODO: Disparar evento OrdenPagada
            // event(new OrdenPagada($orden));

            return true;
        } catch (\Exception $e) {
            // Log del error
            Log::error('Error procesando notificación de pago: ' . $e->getMessage());
            return false;
        }
    }
}
