<?php

namespace Src\Admin\categorias\infrastructure\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Src\Admin\categorias\application\CategoriaService;
use Src\Admin\categorias\domain\Entities\Categoria;
use Src\Admin\categorias\infrastructure\Http\Requests\StoreCategoriaRequest;
use Src\Admin\categorias\infrastructure\Http\Requests\UpdateCategoriaRequest;
use OpenApi\Annotations as OA;

class CategoriaController extends Controller
{
    public function __construct(private readonly CategoriaService $service)
    {
    }

    /**
     * @OA\Get(
     *     path="/api/Admin_categorias/categorias",
     *     tags={"Categorias"},
     *     summary="Obtener todas las categorías",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de categorías",
     *         @OA\JsonContent(type="array", @OA\Items(
     *             @OA\Property(property="id", type="integer", readOnly=true),
     *             @OA\Property(property="nombre", type="string"),
     *             @OA\Property(property="descripcion", type="string", nullable=true),
     *             @OA\Property(property="tipo_categoria", type="string", enum={"PRODUCTO", "SERVICIO"}),
     *             @OA\Property(property="icono_clave", type="string", nullable=true),
     *             @OA\Property(property="activo", type="boolean")
     *         ))
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json($this->service->findAll());
    }

    /**
     * @OA\Post(
     *     path="/api/Admin_categorias/categorias",
     *     tags={"Categorias"},
     *     summary="Crear una nueva categoría",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              @OA\Property(property="nombre", type="string", example="Cortes de Cabello"),
     *              @OA\Property(property="descripcion", type="string", example="Servicios de corte de cabello para hombres."),
     *              @OA\Property(property="tipo_categoria", type="string", enum={"PRODUCTO", "SERVICIO"}, example="SERVICIO"),
     *              @OA\Property(property="icono_clave", type="string", example="haircut_icon"),
     *              @OA\Property(property="activo", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(response=201, description="Categoría creada"),
     *     @OA\Response(response=422, description="Error de validación")
     * )
     */
    public function store(StoreCategoriaRequest $request): JsonResponse
    {
        $data = $request->validated();
        $categoria = new Categoria(
            null,
            $data['nombre'],
            $data['descripcion'] ?? null,
            $data['tipo_categoria'],
            $data['icono_clave'] ?? null,
            $data['activo'] ?? true
        );
        $this->service->save($categoria);
        return response()->json(null, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/Admin_categorias/categorias/{id}",
     *     tags={"Categorias"},
     *     summary="Obtener una categoría por ID",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles de la categoría",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", readOnly=true),
     *             @OA\Property(property="nombre", type="string"),
     *             @OA\Property(property="descripcion", type="string", nullable=true),
     *             @OA\Property(property="tipo_categoria", type="string", enum={"PRODUCTO", "SERVICIO"}),
     *             @OA\Property(property="icono_clave", type="string", nullable=true),
     *             @OA\Property(property="activo", type="boolean")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Categoría no encontrada")
     * )
     */
    public function show(int $id): JsonResponse
    {
        $categoria = $this->service->findById($id);
        return response()->json($categoria);
    }

    /**
     * @OA\Put(
     *     path="/api/Admin_categorias/categorias/{id}",
     *     tags={"Categorias"},
     *     summary="Actualizar una categoría",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              @OA\Property(property="nombre", type="string", example="Cortes de Cabello"),
     *              @OA\Property(property="descripcion", type="string", example="Servicios de corte de cabello para hombres."),
     *              @OA\Property(property="tipo_categoria", type="string", enum={"PRODUCTO", "SERVICIO"}, example="SERVICIO"),
     *              @OA\Property(property="icono_clave", type="string", example="haircut_icon"),
     *              @OA\Property(property="activo", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(response=204, description="Categoría actualizada"),
     *     @OA\Response(response=404, description="Categoría no encontrada"),
     *     @OA\Response(response=422, description="Error de validación")
     * )
     */
    public function update(UpdateCategoriaRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $categoria = new Categoria(
            $id,
            $data['nombre'],
            $data['descripcion'] ?? null,
            $data['tipo_categoria'],
            $data['icono_clave'] ?? null,
            $data['activo'] ?? true
        );
        $this->service->update($id, $categoria);
        return response()->json(null, 204);
    }

    /**
     * @OA\Delete(
     *     path="/api/Admin_categorias/categorias/{id}",
     *     tags={"Categorias"},
     *     summary="Eliminar una categoría",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="Categoría eliminada"),
     *     @OA\Response(response=404, description="Categoría no encontrada")
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $this->service->delete($id);
        return response()->json(null, 204);
    }
}


