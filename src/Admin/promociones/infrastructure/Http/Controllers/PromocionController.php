<?php

namespace Src\Admin\promociones\infrastructure\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Src\Admin\promociones\application\PromocionService;
use Src\Admin\promociones\domain\Entities\Promocion;
use Src\Admin\promociones\infrastructure\Http\Requests\StorePromocionRequest;
use Src\Admin\promociones\infrastructure\Http\Requests\UpdatePromocionRequest;
use OpenApi\Annotations as OA;
use Carbon\Carbon;

class PromocionController extends Controller
{
    public function __construct(private readonly PromocionService $service)
    {
    }

    /**
     * @OA\Get(
     * path="/api/Admin_promociones/promociones",
     * tags={"Promociones"},
     * summary="Obtener todas las promociones",
     * security={{"bearerAuth":{}}},
     * @OA\Response(response=200, description="Lista de promociones")
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json($this->service->findAll());
    }

    /**
     * @OA\Post(
     * path="/api/Admin_promociones/promociones",
     * tags={"Promociones"},
     * summary="Crear una nueva promoción",
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * @OA\Property(property="codigo", type="string", example="VERANO25"),
     * @OA\Property(property="nombre", type="string", example="Descuento de Verano"),
     * @OA\Property(property="tipo_descuento", type="string", enum={"PORCENTAJE", "MONTO_FIJO"}, example="PORCENTAJE"),
     * @OA\Property(property="valor_descuento", type="number", format="float", example=25),
     * @OA\Property(property="fecha_inicio", type="string", format="date-time", example="2025-06-01 00:00:00"),
     * @OA\Property(property="fecha_fin", type="string", format="date-time", example="2025-08-31 23:59:59")
     * )
     * ),
     * @OA\Response(
     * response=201,
     * description="Promoción creada exitosamente.",
     * @OA\JsonContent(@OA\Property(property="message", type="string", example="Promoción creada exitosamente"))
     * ),
     * @OA\Response(response=422, description="Error de validación")
     * )
     */
    public function store(StorePromocionRequest $request): JsonResponse
    {
        $data = $request->validated();
        $promocion = new Promocion(
            null,
            $data['codigo'],
            $data['nombre'],
            $data['descripcion'] ?? null,
            $data['tipo_descuento'],
            (float) $data['valor_descuento'],
            $data['fecha_inicio'],
            $data['fecha_fin'] ?? null,
            $data['usos_maximos_total'] ?? null,
            $data['usos_maximos_por_cliente'] ?? 1,
            0, // usos_actuales
            $data['activo'] ?? true,
            $data['aplica_a_todos_productos'] ?? false,
            $data['aplica_a_todos_servicios'] ?? false
        );
        
        $this->service->save($promocion);
        return response()->json(['message' => 'Promoción creada exitosamente'], 201);
    }

    /**
     * @OA\Get(
     * path="/api/Admin_promociones/promociones/{id}",
     * tags={"Promociones"},
     * summary="Obtener una promoción por ID",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Detalles de la promoción"),
     * @OA\Response(response=404, description="Promoción no encontrada")
     * )
     */
    public function show(int $id): JsonResponse
    {
        $promocion = $this->service->findById($id);
        if (!$promocion) {
            return response()->json(['message' => 'Promoción no encontrada'], 404);
        }
        return response()->json($promocion);
    }
    
    /**
     * @OA\Put(
     * path="/api/Admin_promociones/promociones/{id}",
     * tags={"Promociones"},
     * summary="Actualizar una promoción",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * @OA\Property(property="nombre", type="string", example="Descuento Especial de Verano"),
     * @OA\Property(property="activo", type="boolean", example=false)
     * )
     * ),
     * @OA\Response(response=204, description="Promoción actualizada."),
     * @OA\Response(response=404, description="Promoción no encontrada.")
     * )
     */
    public function update(UpdatePromocionRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $existing = $this->service->findById($id);

        if (!$existing) {
            return response()->json(['message' => 'Promoción no encontrada'], 404);
        }

        $promocion = new Promocion(
            $id,
            $data['codigo'] ?? $existing->codigo,
            $data['nombre'] ?? $existing->nombre,
            $data['descripcion'] ?? $existing->descripcion,
            $data['tipo_descuento'] ?? $existing->tipo_descuento,
            isset($data['valor_descuento']) ? (float) $data['valor_descuento'] : $existing->valor_descuento,
            $data['fecha_inicio'] ?? $existing->fecha_inicio,
            $data['fecha_fin'] ?? $existing->fecha_fin,
            $data['usos_maximos_total'] ?? $existing->usos_maximos_total,
            $data['usos_maximos_por_cliente'] ?? $existing->usos_maximos_por_cliente,
            $existing->usos_actuales, // No se actualiza directamente
            $data['activo'] ?? $existing->activo,
            $data['aplica_a_todos_productos'] ?? $existing->aplica_a_todos_productos,
            $data['aplica_a_todos_servicios'] ?? $existing->aplica_a_todos_servicios
        );

        $this->service->update($id, $promocion);
        return response()->json(null, 204);
    }

    /**
     * @OA\Delete(
     * path="/api/Admin_promociones/promociones/{id}",
     * tags={"Promociones"},
     * summary="Eliminar una promoción (Soft Delete)",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=204, description="Promoción eliminada."),
     * @OA\Response(response=404, description="Promoción no encontrada.")
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $this->service->delete($id);
        return response()->json(null, 204);
    }
}