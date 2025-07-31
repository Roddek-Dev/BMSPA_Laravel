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
use OpenApi\Annotations as OA;
use Carbon\Carbon;

class OrdenController extends Controller
{
    public function __construct(
        private readonly OrdenService $service
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
     * @OA\Get(
     * path="/api/Client_ordenes/ordenes/all",
     * tags={"Órdenes de Cliente"},
     * summary="Obtener todas las órdenes de todos los usuarios (Solo ADMIN_SUCURSAL y ADMIN_GENERAL)",
     * security={{"bearerAuth":{}}},
     * @OA\Response(response=200, description="Lista de todas las órdenes."),
     * @OA\Response(response=403, description="No autorizado.")
     * )
     */
    public function getAllOrders(Request $request): JsonResponse
    {
        $ordenes = $this->service->findAll();
        return response()->json([
            'success' => true,
            'data' => $ordenes,
            'total' => count($ordenes)
        ]);
    }

    /**
     * @OA\Post(
     * path="/api/Client_ordenes/ordenes",
     * tags={"Órdenes de Cliente"},
     * summary="Crear una nueva orden con sus detalles",
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
     * description="Orden creada exitosamente.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Orden creada exitosamente."),
     * @OA\Property(property="orden_id", type="integer", example=123),
     * @OA\Property(property="data", type="object", description="Datos de la orden creada")
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

        // 5. Devolver la orden creada
        return response()->json([
            'message' => 'Orden creada exitosamente.',
            'orden_id' => $ordenGuardada->id,
            'data' => $ordenGuardada
        ], 201);
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
    public function show(Request $request, string $id): JsonResponse
    {
        $orden = $this->service->findById((int) $id);
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
    public function update(UpdateOrdenRequest $request, string $id): JsonResponse
    {
        $orden = $this->service->findById((int) $id);
        if (!$orden) {
            return response()->json(['message' => 'Orden no encontrada'], 404);
        }

        $data = $request->validated();
        $updatedOrden = new Orden(
            (int) $id,
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

        $this->service->update((int) $id, $updatedOrden);
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
    public function destroy(Request $request, string $id): JsonResponse
    {
        $orden = $this->service->findById((int) $id);
        if (!$orden || $orden->cliente_usuario_id !== $request->user()->id) {
            // Un cliente solo puede cancelar su propia orden.
            return response()->json(['message' => 'Orden no encontrada o no autorizada'], 404);
        }

        $this->service->delete((int) $id);
        return response()->json(null, 204);
    }
}
