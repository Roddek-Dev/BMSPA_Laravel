<?php

namespace Src\Client\ordenes\infrastructure\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Client\ordenes\application\OrdenService;
use Src\Client\ordenes\domain\Entities\Orden;
use Src\Client\ordenes\infrastructure\Http\Requests\StoreOrdenRequest;
use Src\Client\ordenes\infrastructure\Http\Requests\UpdateOrdenRequest;
use Src\Catalog\productos\infrastructure\Models\ProductoModel;
use Src\Payments\transacciones_pago\application\PagoService;
use OpenApi\Annotations as OA;
use Carbon\Carbon;

class OrdenController extends Controller
{
    public function __construct(
        private readonly OrdenService $service,
        private readonly PagoService $pagoService
    ) {}

    /**
     * @OA\Get(
     * path="/api/Client_ordenes/ordenes",
     * tags={"Órdenes de Cliente"},
     * summary="Obtener todas las órdenes del cliente autenticado",
     * security={{"bearerAuth":{}}},
     * @OA\Response(response=200, description="Lista de órdenes del cliente.")
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $clientId = $request->user()->id;
        $ordenes = $this->service->findAllByClient($clientId);
        return response()->json($ordenes);
    }

    /**
     * @OA\Post(
     * path="/api/Client_ordenes/ordenes",
     * tags={"Órdenes de Cliente"},
     * summary="Crear una nueva orden con sus detalles e iniciar pago con Mercado Pago",
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * @OA\Property(property="notas_orden", type="string", example="Por favor, envolver para regalo."),
     * @OA\Property(property="detalles", type="array", @OA\Items(
     * @OA\Property(property="producto_id", type="integer", example=1),
     * @OA\Property(property="cantidad", type="integer", example=2)
     * ))
     * )
     * ),
     * @OA\Response(
     * response=201,
     * description="Orden creada y preferencia de pago generada.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Orden creada, pendiente de pago."),
     * @OA\Property(property="orden_id", type="integer", example=123),
     * @OA\Property(property="preference_id", type="string", example="PREFERENCIA_GENERADA_POR_MP")
     * )
     * ),
     * @OA\Response(response=422, description="Error de validación.")
     * )
     */
    public function store(StoreOrdenRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $detallesInput = $validatedData['detalles'];

        $subtotal = 0;
        $detallesParaGuardar = [];

        // 1. Calcular totales y preparar detalles de forma segura en el backend
        foreach ($detallesInput as $item) {
            $producto = ProductoModel::findOrFail($item['producto_id']);
            $subtotalLinea = $producto->precio * $item['cantidad'];
            $subtotal += $subtotalLinea;

            $detallesParaGuardar[] = [
                'producto_id' => $producto->id,
                'nombre_producto_historico' => $producto->nombre,
                'cantidad' => $item['cantidad'],
                'precio_unitario_historico' => $producto->precio,
                'subtotal_linea' => $subtotalLinea,
            ];
        }

        // 2. Lógica de negocio para impuestos, descuentos, etc.
        $impuestos = $subtotal * 0.16; // Ejemplo: 16% de IVA
        $totalOrden = $subtotal + $impuestos;

        // 3. Crear la entidad de la Orden con los datos calculados en el backend
        $orden = new Orden(
            null,
            $request->user()->id,
            'ORD-' . time() . '-' . $request->user()->id,
            Carbon::now()->toDateTimeString(),
            null,
            $subtotal,
            0.00, // descuento_total
            $impuestos,
            $totalOrden,
            'PENDIENTE_PAGO',
            $validatedData['notas_orden'] ?? null
        );

        // 4. Guardar la orden y sus detalles
        $ordenGuardada = $this->service->save($orden, $detallesParaGuardar);

        // 5. Obtener el modelo OrdenModel para Mercado Pago
        $ordenModel = \Src\Client\ordenes\infrastructure\Models\OrdenModel::with('detalles')->find($ordenGuardada->id);

        // 6. Crear preferencia de pago en Mercado Pago
        try {
            $preferenciaPago = $this->pagoService->crearPreferenciaPago($ordenModel);

            return response()->json([
                'message' => 'Orden creada, pendiente de pago.',
                'orden_id' => $ordenGuardada->id,
                'preference_id' => $preferenciaPago['preference_id']
            ], 201);
        } catch (\Exception $e) {
            // Si falla la creación de la preferencia, aún devolvemos la orden creada
            // pero con un mensaje de advertencia
            return response()->json([
                'message' => 'Orden creada pero hubo un problema con el pago. Contacte al administrador.',
                'orden_id' => $ordenGuardada->id,
                'error' => 'Error al generar preferencia de pago'
            ], 201);
        }
    }

    /**
     * @OA\Get(
     * path="/api/Client_ordenes/ordenes/{id}",
     * tags={"Órdenes de Cliente"},
     * summary="Obtener una orden propia por ID",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Detalles de la orden."),
     * @OA\Response(response=404, description="Orden no encontrada."),
     * @OA\Response(response=403, description="No autorizado.")
     * )
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $orden = $this->service->findById($id);
        if (!$orden || $orden->cliente_usuario_id !== $request->user()->id) {
            return response()->json(['message' => 'Orden no encontrada o no autorizada'], 404);
        }
        return response()->json($orden);
    }

    /**
     * @OA\Put(
     * path="/api/Client_ordenes/ordenes/{id}",
     * tags={"Órdenes de Cliente"},
     * summary="Actualizar el estado de una orden (Admin)",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * @OA\Property(property="estado_orden", type="string", example="ENVIADA")
     * )
     * ),
     * @OA\Response(response=204, description="Orden actualizada."),
     * @OA\Response(response=404, description="Orden no encontrada.")
     * )
     */
    public function update(UpdateOrdenRequest $request, int $id): JsonResponse
    {
        $orden = $this->service->findById($id);
        if (!$orden) {
            return response()->json(['message' => 'Orden no encontrada'], 404);
        }

        $data = $request->validated();
        $updatedOrden = new Orden(
            $id,
            $orden->cliente_usuario_id,
            $orden->numero_orden,
            $orden->fecha_orden,
            $data['estado_orden'] === 'ENTREGADA' && !$orden->fecha_recibida ? Carbon::now()->toDateTimeString() : $orden->fecha_recibida,
            $orden->subtotal,
            $orden->descuento_total,
            $orden->impuestos_total,
            $orden->total_orden,
            $data['estado_orden'] ?? $orden->estado_orden,
            $data['notas_orden'] ?? $orden->notas_orden
        );

        $this->service->update($id, $updatedOrden);
        return response()->json(null, 204);
    }

    /**
     * @OA\Delete(
     * path="/api/Client_ordenes/ordenes/{id}",
     * tags={"Órdenes de Cliente"},
     * summary="Cancelar una orden (Soft Delete)",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=204, description="Orden cancelada."),
     * @OA\Response(response=404, description="Orden no encontrada.")
     * )
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $orden = $this->service->findById($id);
        if (!$orden || $orden->cliente_usuario_id !== $request->user()->id) {
            // Un cliente solo puede cancelar su propia orden.
            return response()->json(['message' => 'Orden no encontrada o no autorizada'], 404);
        }

        $this->service->delete($id);
        return response()->json(null, 204);
    }
}
