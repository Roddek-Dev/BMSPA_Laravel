<?php

namespace Src\Admin\especialidades\infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Src\Admin\especialidades\application\EspecialidadService;
use Src\Admin\especialidades\domain\Entities\Especialidad;
use Src\Admin\especialidades\infrastructure\Http\Requests\EspecialidadRequest;
use OpenApi\Annotations as OA;

class EspecialidadController extends Controller
{
    protected $especialidadService;

    public function __construct(EspecialidadService $especialidadService)
    {
        $this->especialidadService = $especialidadService;
    }

    /**
     * @OA\Get(
     *     path="/api/Admin_especialidades/especialidades",
     *     summary="Obtener todas las especialidades",
     *     tags={"Especialidades"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de especialidades",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nombre", type="string", example="Barbería Clásica"),
     *                 @OA\Property(property="descripcion", type="string", example="Cortes de cabello y afeitados tradicionales."),
     *                 @OA\Property(property="activo", type="boolean", example=true)
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $especialidades = $this->especialidadService->findAll();
        return response()->json($especialidades);
    }

    /**
     * @OA\Post(
     *     path="/api/Admin_especialidades/especialidades",
     *     summary="Crear una nueva especialidad",
     *     tags={"Especialidades"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre", "activo"},
     *             @OA\Property(property="nombre", type="string", example="Barbería Clásica"),
     *             @OA\Property(property="descripcion", type="string", example="Cortes de cabello y afeitados tradicionales."),
     *             @OA\Property(property="icono_clave", type="string", example="corte_hombre"),
     *             @OA\Property(property="activo", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Especialidad creada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Especialidad creada exitosamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación"
     *     )
     * )
     */
    public function store(EspecialidadRequest $request)
    {
        $data = $request->validated();
        $especialidad = new Especialidad(
            null,
            $data['nombre'],
            $data['descripcion'] ?? null,
            $data['icono_clave'] ?? null,
            $data['activo']
        );
        $this->especialidadService->save($especialidad);
        return response()->json(['message' => 'Especialidad creada exitosamente'], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/Admin_especialidades/especialidades/{id}",
     *     summary="Obtener una especialidad por ID",
     *     tags={"Especialidades"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la especialidad",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Especialidad encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="nombre", type="string", example="Barbería Clásica"),
     *             @OA\Property(property="descripcion", type="string", example="Cortes de cabello y afeitados tradicionales."),
     *             @OA\Property(property="icono_clave", type="string", example="corte_hombre"),
     *             @OA\Property(property="activo", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Especialidad no encontrada"
     *     )
     * )
     */
    public function show(int $id)
    {
        $especialidad = $this->especialidadService->findById($id);
        if (!$especialidad) {
            return response()->json(['message' => 'Especialidad no encontrada'], 404);
        }
        return response()->json($especialidad);
    }

    /**
     * @OA\Put(
     *     path="/api/Admin_especialidades/especialidades/{id}",
     *     summary="Actualizar una especialidad",
     *     tags={"Especialidades"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la especialidad",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre", "activo"},
     *             @OA\Property(property="nombre", type="string", example="Barbería Clásica"),
     *             @OA\Property(property="descripcion", type="string", example="Cortes de cabello y afeitados tradicionales."),
     *             @OA\Property(property="icono_clave", type="string", example="corte_hombre"),
     *             @OA\Property(property="activo", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Especialidad actualizada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Especialidad actualizada exitosamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Especialidad no encontrada"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación"
     *     )
     * )
     */
    public function update(EspecialidadRequest $request, int $id)
    {
        $data = $request->validated();
        $especialidad = new Especialidad(
            null,
            $data['nombre'],
            $data['descripcion'] ?? null,
            $data['icono_clave'] ?? null,
            $data['activo']
        );
        $this->especialidadService->update($id, $especialidad);
        return response()->json(['message' => 'Especialidad actualizada exitosamente']);
    }

    /**
     * @OA\Delete(
     *     path="/api/Admin_especialidades/especialidades/{id}",
     *     summary="Eliminar una especialidad",
     *     tags={"Especialidades"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la especialidad",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Especialidad eliminada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Especialidad eliminada exitosamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Especialidad no encontrada"
     *     )
     * )
     */
    public function destroy(int $id)
    {
        $this->especialidadService->delete($id);
        return response()->json(['message' => 'Especialidad eliminada exitosamente']);
    }
}
