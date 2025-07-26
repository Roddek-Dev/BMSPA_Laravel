<?php

namespace Src\Catalog\servicios\infrastructure\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Src\Catalog\servicios\application\ServicioService;
use Src\Catalog\servicios\domain\Entities\Servicio;
use Src\Catalog\servicios\infrastructure\Http\Requests\StoreServicioRequest;
use Src\Catalog\servicios\infrastructure\Http\Requests\UpdateServicioRequest;
use OpenApi\Annotations as OA;

class ServicioController extends Controller
{
    public function __construct(private readonly ServicioService $service)
    {
    }

    /**
     * @OA\Get(
     * path="/api/Catalog_servicios/servicios",
     * tags={"Servicios"},
     * summary="Obtener todos los servicios",
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     * response=200,
     * description="Lista de servicios",
     * @OA\JsonContent(type="array", @OA\Items(
     * @OA\Property(property="id", type="integer"),
     * @OA\Property(property="nombre", type="string"),
     * @OA\Property(property="descripcion", type="string", nullable=true),
     * @OA\Property(property="imagen_path", type="string", nullable=true),
     * @OA\Property(property="precio_base", type="number", format="float"),
     * @OA\Property(property="duracion_minutos", type="integer"),
     * @OA\Property(property="categoria_id", type="integer", nullable=true),
     * @OA\Property(property="especialidad_requerida_id", type="integer", nullable=true),
     * @OA\Property(property="activo", type="boolean")
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
     * path="/api/Catalog_servicios/servicios",
     * tags={"Servicios"},
     * summary="Crear un nuevo servicio",
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * @OA\Property(property="nombre", type="string", example="Corte de Cabello Clásico"),
     * @OA\Property(property="descripcion", type="string", example="Corte con máquina y tijera."),
     * @OA\Property(property="precio_base", type="number", format="float", example=250.00),
     * @OA\Property(property="duracion_minutos", type="integer", example=30),
     * @OA\Property(property="categoria_id", type="integer", example=1),
     * @OA\Property(property="especialidad_requerida_id", type="integer", example=1),
     * @OA\Property(property="activo", type="boolean", example=true)
     * )
     * ),
     * @OA\Response(
     * response=201,
     * description="Servicio creado exitosamente.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Servicio creado exitosamente")
     * )
     * ),
     * @OA\Response(response=422, description="Error de validación")
     * )
     */
    public function store(StoreServicioRequest $request): JsonResponse
    {
        $data = $request->validated();
        $servicio = new Servicio(
            null,
            $data['nombre'],
            $data['descripcion'] ?? null,
            $data['imagen_path'] ?? null,
            (float) $data['precio_base'],
            (int) $data['duracion_minutos'],
            $data['categoria_id'] ?? null,
            $data['especialidad_requerida_id'] ?? null,
            $data['activo'] ?? true
        );

        $this->service->save($servicio);

        return response()->json(['message' => 'Servicio creado exitosamente'], 201);
    }

    /**
     * @OA\Get(
     * path="/api/Catalog_servicios/servicios/{id}",
     * tags={"Servicios"},
     * summary="Obtener un servicio por ID",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Detalles del servicio"),
     * @OA\Response(response=404, description="Servicio no encontrado")
     * )
     */
    public function show(int $id): JsonResponse
    {
        $servicio = $this->service->findById($id);
        if (!$servicio) {
            return response()->json(['message' => 'Servicio no encontrado'], 404);
        }
        return response()->json($servicio);
    }

    /**
     * @OA\Put(
     * path="/api/Catalog_servicios/servicios/{id}",
     * tags={"Servicios"},
     * summary="Actualizar un servicio",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * @OA\Property(property="nombre", type="string", example="Corte de Barba"),
     * @OA\Property(property="precio_base", type="number", format="float", example=150.00)
     * )
     * ),
     * @OA\Response(response=204, description="Servicio actualizado"),
     * @OA\Response(response=404, description="Servicio no encontrado")
     * )
     */
    public function update(UpdateServicioRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $existingServicio = $this->service->findById($id);

        if (!$existingServicio) {
            return response()->json(['message' => 'Servicio no encontrado'], 404);
        }

        $servicio = new Servicio(
            $id,
            $data['nombre'] ?? $existingServicio->nombre,
            $data['descripcion'] ?? $existingServicio->descripcion,
            $data['imagen_path'] ?? $existingServicio->imagen_path,
            isset($data['precio_base']) ? (float) $data['precio_base'] : $existingServicio->precio_base,
            isset($data['duracion_minutos']) ? (int) $data['duracion_minutos'] : $existingServicio->duracion_minutos,
            $data['categoria_id'] ?? $existingServicio->categoria_id,
            $data['especialidad_requerida_id'] ?? $existingServicio->especialidad_requerida_id,
            $data['activo'] ?? $existingServicio->activo
        );
        
        $this->service->update($id, $servicio);
        return response()->json(null, 204);
    }

    /**
     * @OA\Delete(
     * path="/api/Catalog_servicios/servicios/{id}",
     * tags={"Servicios"},
     * summary="Eliminar un servicio (Soft Delete)",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=204, description="Servicio eliminado"),
     * @OA\Response(response=404, description="Servicio no encontrado")
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $this->service->delete($id);
        return response()->json(null, 204);
    }
}