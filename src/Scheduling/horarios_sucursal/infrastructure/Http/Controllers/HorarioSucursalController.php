<?php

namespace Src\Scheduling\horarios_sucursal\infrastructure\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Src\Scheduling\horarios_sucursal\application\HorarioSucursalService;
use Src\Scheduling\horarios_sucursal\domain\Entities\HorarioSucursal;
use Src\Scheduling\horarios_sucursal\infrastructure\Http\Requests\StoreHorarioSucursalRequest;
use Src\Scheduling\horarios_sucursal\infrastructure\Http\Requests\UpdateHorarioSucursalRequest;
use OpenApi\Annotations as OA;

class HorarioSucursalController extends Controller
{
    public function __construct(private readonly HorarioSucursalService $service)
    {
    }

    /**
     * @OA\Get(
     * path="/api/Scheduling_horarios_sucursal/horarios",
     * tags={"Horarios Sucursal"},
     * summary="Obtener todos los horarios de sucursales",
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     * response=200,
     * description="Lista de horarios",
     * @OA\JsonContent(type="array", @OA\Items(
     * @OA\Property(property="id", type="integer", readOnly=true),
     * @OA\Property(property="sucursal_id", type="integer"),
     * @OA\Property(property="dia_semana", type="integer", description="0=Domingo, 1=Lunes,..., 6=Sábado"),
     * @OA\Property(property="hora_apertura", type="string", format="time", nullable=true),
     * @OA\Property(property="hora_cierre", type="string", format="time", nullable=true),
     * @OA\Property(property="esta_cerrado_regularmente", type="boolean")
     * ))
     * )
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json($this->service->findAll());
    }

    /**
     * @OA\Post(
     * path="/api/Scheduling_horarios_sucursal/horarios",
     * tags={"Horarios Sucursal"},
     * summary="Crear un nuevo horario para una sucursal",
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * @OA\Property(property="sucursal_id", type="integer", example=1),
     * @OA\Property(property="dia_semana", type="integer", example=1, description="0=Domingo, 1=Lunes,..., 6=Sábado"),
     * @OA\Property(property="hora_apertura", type="string", format="time", example="09:00"),
     * @OA\Property(property="hora_cierre", type="string", format="time", example="18:00"),
     * @OA\Property(property="esta_cerrado_regularmente", type="boolean", example=false)
     * )
     * ),
     * @OA\Response(response=201, description="Horario creado"),
     * @OA\Response(response=422, description="Error de validación")
     * )
     */
    public function store(StoreHorarioSucursalRequest $request): JsonResponse
    {
        $data = $request->validated();
        $horario = new HorarioSucursal(
            null,
            $data['sucursal_id'],
            $data['dia_semana'],
            $data['hora_apertura'] ?? null,
            $data['hora_cierre'] ?? null,
            $data['esta_cerrado_regularmente'] ?? false
        );
        $this->service->save($horario);
        return response()->json(null, 201);
    }

    /**
     * @OA\Get(
     * path="/api/Scheduling_horarios_sucursal/horarios/{id}",
     * tags={"Horarios Sucursal"},
     * summary="Obtener un horario por ID",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(
     * response=200,
     * description="Detalles del horario",
     * @OA\JsonContent(
     * @OA\Property(property="id", type="integer", readOnly=true),
     * @OA\Property(property="sucursal_id", type="integer"),
     * @OA\Property(property="dia_semana", type="integer", description="0=Domingo, 1=Lunes,..., 6=Sábado"),
     * @OA\Property(property="hora_apertura", type="string", format="time", nullable=true),
     * @OA\Property(property="hora_cierre", type="string", format="time", nullable=true),
     * @OA\Property(property="esta_cerrado_regularmente", type="boolean")
     * )
     * ),
     * @OA\Response(response=404, description="Horario no encontrado")
     * )
     */
    public function show(int $id): JsonResponse
    {
        $horario = $this->service->findById($id);
        return response()->json($horario);
    }

    /**
     * @OA\Put(
     * path="/api/Scheduling_horarios_sucursal/horarios/{id}",
     * tags={"Horarios Sucursal"},
     * summary="Actualizar un horario de sucursal",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * @OA\Property(property="sucursal_id", type="integer", example=1),
     * @OA\Property(property="dia_semana", type="integer", example=1, description="0=Domingo, 1=Lunes,..., 6=Sábado"),
     * @OA\Property(property="hora_apertura", type="string", format="time", example="09:00"),
     * @OA\Property(property="hora_cierre", type="string", format="time", example="18:00"),
     * @OA\Property(property="esta_cerrado_regularmente", type="boolean", example=false)
     * )
     * ),
     * @OA\Response(response=204, description="Horario actualizado"),
     * @OA\Response(response=404, description="Horario no encontrado"),
     * @OA\Response(response=422, description="Error de validación")
     * )
     */
    public function update(UpdateHorarioSucursalRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $horario = $this->service->findById($id);
        
        $updatedHorario = new HorarioSucursal(
            $id,
            $data['sucursal_id'] ?? $horario->sucursal_id,
            $data['dia_semana'] ?? $horario->dia_semana,
            $data['hora_apertura'] ?? $horario->hora_apertura,
            $data['hora_cierre'] ?? $horario->hora_cierre,
            $data['esta_cerrado_regularmente'] ?? $horario->esta_cerrado_regularmente
        );
        $this->service->update($id, $updatedHorario);
        return response()->json(null, 204);
    }

    /**
     * @OA\Delete(
     * path="/api/Scheduling_horarios_sucursal/horarios/{id}",
     * tags={"Horarios Sucursal"},
     * summary="Eliminar un horario de sucursal",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=204, description="Horario eliminado"),
     * @OA\Response(response=404, description="Horario no encontrado")
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $this->service->delete($id);
        return response()->json(null, 204);
    }
}