<?php

namespace Src\Admin\personal\infrastructure\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Src\Admin\personal\application\PersonalService;
use Src\Admin\personal\domain\Entities\Personal;
use Src\Admin\personal\infrastructure\Http\Requests\StorePersonalRequest;
use Src\Admin\personal\infrastructure\Http\Requests\UpdatePersonalRequest;
use OpenApi\Annotations as OA;

class PersonalController extends Controller
{
    public function __construct(private readonly PersonalService $service) {}

    /**
     * @OA\Get(
     * path="/api/Admin_personal/personal",
     * tags={"Personal"},
     * summary="Obtener todo el personal",
     * security={{"bearerAuth":{}}},
     * @OA\Response(response=200, description="Lista del personal")
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json($this->service->findAll());
    }

    /**
     * @OA\Post(
     * path="/api/Admin_personal/personal",
     * tags={"Personal"},
     * summary="Crear un nuevo registro de personal",
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * @OA\Property(property="usuario_id", type="integer", example=2),
     * @OA\Property(property="sucursal_asignada_id", type="integer", example=1),
     * @OA\Property(property="tipo_personal", type="string", example="BARBERO"),
     * @OA\Property(property="numero_empleado", type="string", example="EMP-001"),
     * @OA\Property(property="fecha_contratacion", type="string", format="date", example="2025-01-15"),
     * @OA\Property(property="activo_en_empresa", type="boolean", example=true)
     * )
     * ),
     * @OA\Response(
     * response=201,
     * description="Personal creado exitosamente.",
     * @OA\JsonContent(@OA\Property(property="message", type="string", example="Personal creado exitosamente"))
     * ),
     * @OA\Response(response=422, description="Error de validación")
     * )
     */
    public function store(StorePersonalRequest $request): JsonResponse
    {
        $data = $request->validated();
        $personal = new Personal(
            null,
            $data['usuario_id'],
            $data['sucursal_asignada_id'] ?? null,
            $data['tipo_personal'],
            $data['numero_empleado'] ?? null,
            $data['fecha_contratacion'] ?? null,
            $data['activo_en_empresa'] ?? true
        );
        $this->service->save($personal);
        return response()->json(['message' => 'Personal creado exitosamente'], 201);
    }

    /**
     * @OA\Get(
     * path="/api/Admin_personal/personal/{id}",
     * tags={"Personal"},
     * summary="Obtener un registro de personal por ID",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Detalles del personal"),
     * @OA\Response(response=404, description="Personal no encontrado")
     * )
     */
    public function show(int $id): JsonResponse
    {
        $personal = $this->service->findById($id);
        if (!$personal) {
            return response()->json(['message' => 'Personal no encontrado'], 404);
        }
        return response()->json($personal);
    }

    /**
     * @OA\Put(
     * path="/api/Admin_personal/personal/{id}",
     * tags={"Personal"},
     * summary="Actualizar un registro de personal",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * @OA\Property(property="sucursal_asignada_id", type="integer", example=2),
     * @OA\Property(property="tipo_personal", type="string", example="ESTILISTA"),
     * @OA\Property(property="activo_en_empresa", type="boolean", example=false)
     * )
     * ),
     * @OA\Response(response=204, description="Personal actualizado"),
     * @OA\Response(response=404, description="Personal no encontrado")
     * )
     */
    public function update(UpdatePersonalRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $existing = $this->service->findById($id);

        if (!$existing) {
            return response()->json(['message' => 'Personal no encontrado'], 404);
        }

        $personal = new Personal(
            $id,
            $data['usuario_id'] ?? $existing->usuario_id,
            $data['sucursal_asignada_id'] ?? $existing->sucursal_asignada_id,
            $data['tipo_personal'] ?? $existing->tipo_personal,
            $data['numero_empleado'] ?? $existing->numero_empleado,
            $data['fecha_contratacion'] ?? $existing->fecha_contratacion,
            $data['activo_en_empresa'] ?? $existing->activo_en_empresa
        );

        $this->service->update($id, $personal);
        return response()->json(null, 204);
    }

    /**
     * @OA\Delete(
     * path="/api/Admin_personal/personal/{id}",
     * tags={"Personal"},
     * summary="Eliminar un registro de personal (Soft Delete)",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=204, description="Personal eliminado"),
     * @OA\Response(response=404, description="Personal no encontrado")
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $this->service->delete($id);
        return response()->json(null, 204);
    }

    /**
     * @OA\Get(
     * path="/api/Admin_personal/usuarios",
     * tags={"Personal"},
     * summary="Obtener todos los usuarios para promoción",
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     * response=200,
     * description="Lista de usuarios disponibles",
     * @OA\JsonContent(
     * type="array",
     * @OA\Items(
     * @OA\Property(property="id", type="integer", example=1),
     * @OA\Property(property="nombre", type="string", example="Juan Pérez"),
     * @OA\Property(property="email", type="string", example="juan@example.com"),
     * @OA\Property(property="rol", type="string", example="CLIENTE"),
     * @OA\Property(property="activo", type="boolean", example=true),
     * @OA\Property(property="telefono", type="string", example="1234567890")
     * )
     * )
     * )
     * )
     */
    public function obtenerUsuarios(): JsonResponse
    {
        $usuarios = $this->service->obtenerTodosLosUsuarios();
        return response()->json($usuarios);
    }
}
