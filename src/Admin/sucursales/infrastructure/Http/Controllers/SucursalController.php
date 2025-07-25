<?php

namespace Src\Admin\sucursales\infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Src\Admin\sucursales\application\SucursalService;
use Src\Admin\sucursales\domain\Entities\Sucursal;
use Src\Admin\sucursales\infrastructure\Http\Requests\SucursalRequest;
use OpenApi\Annotations as OA;


class SucursalController extends Controller
{
    protected $sucursalService;

    public function __construct(SucursalService $sucursalService)
    {
        $this->sucursalService = $sucursalService;
    }

    /**
     * @OA\Get(
     *     path="/api/Admin_sucursales/sucursales",
     *     summary="Obtener todas las sucursales",
     *     tags={"Sucursales"},
     *     security={{"bearerAuth":{}}}, 
     *     @OA\Response(
     *         response=200,
     *         description="Lista de sucursales",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nombre", type="string", example="Sucursal Centro"),
     *                 @OA\Property(property="imagen_path", type="string", example="http://example.com/image.jpg", nullable=true),
     *                 @OA\Property(property="telefono_contacto", type="string", example="5512345678", nullable=true),
     *                 @OA\Property(property="email_contacto", type="string", example="centro@example.com", nullable=true),
     *                  @OA\Property(property="link_maps", type="string", example="https://maps.google.com/?q=19.4326,-99.1332", nullable=true),
     *                 @OA\Property(property="latitud", type="number", format="float", example=19.4326, nullable=true),
     *                 @OA\Property(property="longitud", type="number", format="float", example=-99.1332, nullable=true),
     *                 @OA\Property(property="activo", type="boolean", example=true)
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $sucursales = $this->sucursalService->findAll();
        return response()->json($sucursales);
    }

    /**
     * @OA\Post(
     *     path="/api/Admin_sucursales/sucursales",
     *     summary="Crear una nueva sucursal",
     *     tags={"Sucursales"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre", "activo"},
     *             @OA\Property(property="nombre", type="string", example="Sucursal Centro"),
     *             @OA\Property(property="imagen_path", type="string", example="http://example.com/image.jpg", nullable=true),
     *             @OA\Property(property="telefono_contacto", type="string", example="5512345678", nullable=true),
     *             @OA\Property(property="email_contacto", type="string", example="centro@example.com", nullable=true),
     *             @OA\Property(property="link_maps", type="string", example="https://maps.app.goo.gl/example", nullable=true),
     *             @OA\Property(property="latitud", type="number", format="float", example=19.4326, nullable=true),
     *             @OA\Property(property="longitud", type="number", format="float", example=-99.1332, nullable=true),

     *             @OA\Property(property="activo", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Sucursal creada exitosamente"
     *     )
     * )
     */
    public function store(SucursalRequest $request)
    {
        $sucursal = $this->sucursalService->create($request->toEntity());
        return response()->json($sucursal, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/Admin_sucursales/sucursales/{id}",
     *     summary="Obtener una sucursal por ID",
     *     tags={"Sucursales"},
     *     security={{"bearerAuth":{}}},  
     * 
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sucursal encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="nombre", type="string", example="Sucursal Centro"),
     *             @OA\Property(property="imagen_path", type="string", example="http://example.com/image.jpg", nullable=true),
     *             @OA\Property(property="telefono_contacto", type="string", example="5512345678", nullable=true),
     *             @OA\Property(property="email_contacto", type="string", example="centro@example.com", nullable=true),
     *             @OA\Property(property="link_maps", type="string", example="https://maps.app.goo.gl/example", nullable=true),
     *             @OA\Property(property="latitud", type="number", format="float", example=19.4326, nullable=true),
     *             @OA\Property(property="longitud", type="number", format="float", example=-99.1332, nullable=true),
     *             @OA\Property(property="activo", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Sucursal no encontrada"
     *     )
     * )
     */
    public function show(int $id)
    {
        $sucursal = $this->sucursalService->find($id);
        if (!$sucursal) {
            return response()->json(['message' => 'Sucursal no encontrada'], 404);
        }
        return response()->json($sucursal);
    }

    /**
     * @OA\Put(
     *     path="/api/Admin_sucursales/sucursales/{id}",
     *     summary="Actualizar una sucursal",
     *     tags={"Sucursales"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre", "activo"},
     *             @OA\Property(property="nombre", type="string", example="Sucursal Centro"),
     *             @OA\Property(property="imagen_path", type="string", example="http://example.com/image.jpg", nullable=true),
     *             @OA\Property(property="telefono_contacto", type="string", example="5512345678", nullable=true),
     *             @OA\Property(property="email_contacto", type="string", example="centro@example.com", nullable=true),
     *             @OA\Property(property="link_maps", type="string", example="https://maps.app.goo.gl/example", nullable=true),
     *             @OA\Property(property="latitud", type="number", format="float", example=19.4326, nullable=true),
     *             @OA\Property(property="longitud", type="number", format="float", example=-99.1332, nullable=true),
     *             @OA\Property(property="activo", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sucursal actualizada exitosamente"
     *     )
     * )link_maps
    }

    /**
     * @OA\Delete(
     *     path="/api/Admin_sucursales/sucursales/{id}",
     *     summary="Eliminar una sucursal",
     *     tags={"Sucursales"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Sucursal eliminada exitosamente"
     *     )
     * )
     */
    public function destroy(int $id)
    {
        $this->sucursalService->delete($id);
        return response()->json(null, 204);
    }
}
