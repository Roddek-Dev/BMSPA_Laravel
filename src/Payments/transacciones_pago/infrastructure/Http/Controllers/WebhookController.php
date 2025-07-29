<?php

declare(strict_types=1);

namespace Src\Payments\transacciones_pago\infrastructure\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Src\Payments\transacciones_pago\application\PagoService;
use OpenApi\Annotations as OA;

class WebhookController extends Controller
{
    public function __construct(private readonly PagoService $pagoService) {}

    /**
     * @OA\Post(
     * path="/api/webhooks/mercadopago-ipn",
     * tags={"Webhooks"},
     * summary="Webhook para recibir notificaciones de Mercado Pago",
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * @OA\Property(property="type", type="string", example="payment"),
     * @OA\Property(property="data", type="object",
     * @OA\Property(property="id", type="string", example="123456789")
     * )
     * )
     * ),
     * @OA\Response(response=200, description="Notificación procesada correctamente"),
     * @OA\Response(response=400, description="Error en el procesamiento")
     * )
     */
    public function mercadopagoIpn(Request $request): JsonResponse
    {
        try {
            $data = $request->all();

            // Verificar que es una notificación de pago
            if ($data['type'] !== 'payment') {
                return response()->json(['message' => 'Tipo de notificación no soportado'], 400);
            }

            $paymentId = $data['data']['id'];

            // Procesar la notificación
            $procesado = $this->pagoService->procesarNotificacionPago($paymentId);

            if ($procesado) {
                return response()->json(['message' => 'Notificación procesada correctamente'], 200);
            } else {
                return response()->json(['message' => 'Error procesando la notificación'], 400);
            }
        } catch (\Exception $e) {
            Log::error('Error en webhook de Mercado Pago: ' . $e->getMessage());
            return response()->json(['message' => 'Error interno del servidor'], 500);
        }
    }
}
