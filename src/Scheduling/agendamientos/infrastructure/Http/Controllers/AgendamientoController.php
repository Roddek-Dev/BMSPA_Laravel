<?php

namespace Src\Scheduling\agendamientos\infrastructure\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Src\Scheduling\agendamientos\application\AgendamientoService;
use Src\Scheduling\agendamientos\domain\Entities\Agendamiento;
use Src\Scheduling\agendamientos\infrastructure\Http\Requests\StoreAgendamientoRequest;
use Src\Scheduling\agendamientos\infrastructure\Http\Requests\UpdateAgendamientoRequest;
use OpenApi\Annotations as OA;

class AgendamientoController extends Controller
{
    public function __construct(private readonly AgendamientoService $service)
    {
    }

    /**
     * @OA\Get(
     * path="/api/Scheduling_agendamientos/agendamientos",
     * tags={"Agendamientos"},
     * summary="Obtener todos los agendamientos",
     * security={{"bearerAuth":{}}},
     * @OA\Response(response=200, description="Lista de agendamientos")
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json($this->service->findAll());
    }

    /**
     * @OA\Post(
     * path="/api/Scheduling_agendamientos/agendamientos",
     * tags={"Agendamientos"},
     * summary="Crear un nuevo agendamiento",
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * @OA\Property(property="cliente_usuario_id", type="integer", example=1),
     * @OA\Property(property="personal_id", type="integer", example=1),
     * @OA\Property(property="servicio_id", type="integer", example=1),
     * @OA\Property(property="sucursal_id", type="integer", example=1),
     * @OA\Property(property="fecha_hora_inicio", type="string", format="date-time", example="2025-12-25 10:00:00"),
     * @OA\Property(property="fecha_hora_fin", type="string", format="date-time", example="2025-12-25 10:30:00"),
     * @OA\Property(property="precio_final", type="number", format="float", example=250.00),
     * @OA\Property(property="estado", type="string", example="PROGRAMADA"),
     * @OA\Property(property="notas_cliente", type="string", example="Por favor, ser puntual.")
     * )
     * ),
     * @OA\Response(
     * response=201,
     * description="Agendamiento creado exitosamente.",
     * @OA\JsonContent(@OA\Property(property="message", type="string", example="Agendamiento creado exitosamente"))
     * ),
     * @OA\Response(response=422, description="Error de validación")
     * )
     */
    public function store(StoreAgendamientoRequest $request): JsonResponse
    {
        $data = $request->validated();
        $agendamiento = new Agendamiento(
            null,
            (int) $data['cliente_usuario_id'],
            $data['personal_id'] ? (int) $data['personal_id'] : null,
            (int) $data['servicio_id'],
            (int) $data['sucursal_id'],
            $data['fecha_hora_inicio'],
            $data['fecha_hora_fin'],
            (float) $data['precio_final'],
            $data['estado'] ?? 'PROGRAMADA',
            $data['notas_cliente'] ?? null,
            $data['notas_internas'] ?? null
        );

        $this->service->save($agendamiento);

        return response()->json(['message' => 'Agendamiento creado exitosamente'], 201);
    }

    /**
     * @OA\Get(
     * path="/api/Scheduling_agendamientos/agendamientos/{id}",
     * tags={"Agendamientos"},
     * summary="Obtener un agendamiento por ID",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Detalles del agendamiento"),
     * @OA\Response(response=404, description="Agendamiento no encontrado")
     * )
     */
    public function show(int $id): JsonResponse
    {
        $agendamiento = $this->service->findById($id);
        if (!$agendamiento) {
            return response()->json(['message' => 'Agendamiento no encontrado'], 404);
        }
        return response()->json($agendamiento);
    }

    /**
     * @OA\Put(
     * path="/api/Scheduling_agendamientos/agendamientos/{id}",
     * tags={"Agendamientos"},
     * summary="Actualizar un agendamiento",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * @OA\Property(property="estado", type="string", example="CONFIRMADA"),
     * @OA\Property(property="notas_internas", type="string", example="Cliente contactado por teléfono.")
     * )
     * ),
     * @OA\Response(response=204, description="Agendamiento actualizado"),
     * @OA\Response(response=404, description="Agendamiento no encontrado")
     * )
     */
    public function update(UpdateAgendamientoRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $existing = $this->service->findById($id);

        if (!$existing) {
            return response()->json(['message' => 'Agendamiento no encontrado'], 404);
        }

        $agendamiento = new Agendamiento(
            $id,
            $data['cliente_usuario_id'] ?? $existing->cliente_usuario_id,
            isset($data['personal_id']) ? (int) $data['personal_id'] : $existing->personal_id,
            $data['servicio_id'] ?? $existing->servicio_id,
            $data['sucursal_id'] ?? $existing->sucursal_id,
            $data['fecha_hora_inicio'] ?? $existing->fecha_hora_inicio,
            $data['fecha_hora_fin'] ?? $existing->fecha_hora_fin,
            isset($data['precio_final']) ? (float) $data['precio_final'] : $existing->precio_final,
            $data['estado'] ?? $existing->estado,
            $data['notas_cliente'] ?? $existing->notas_cliente,
            $data['notas_internas'] ?? $existing->notas_internas
        );
        
        $this->service->update($id, $agendamiento);
        return response()->json(null, 204);
    }

    /**
     * @OA\Delete(
     * path="/api/Scheduling_agendamientos/agendamientos/{id}",
     * tags={"Agendamientos"},
     * summary="Eliminar un agendamiento (Soft Delete)",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=204, description="Agendamiento eliminado"),
     * @OA\Response(response=404, description="Agendamiento no encontrado")
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $this->service->delete($id);
        return response()->json(null, 204);
    }
}