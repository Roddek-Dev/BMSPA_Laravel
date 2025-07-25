<?php

namespace Src\Catalog\productos\infrastructure\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Src\Catalog\productos\application\ProductoService;
use Src\Catalog\productos\domain\Entities\Producto;
use Src\Catalog\productos\infrastructure\Http\Requests\StoreProductoRequest;
use Src\Catalog\productos\infrastructure\Http\Requests\UpdateProductoRequest;
use OpenApi\Annotations as OA;

class ProductoController extends Controller
{
    public function __construct(private readonly ProductoService $service)
    {
    }

    /**
     * @OA\Get(
     * path="/api/Catalog_productos/productos",
     * tags={"Productos"},
     * summary="Obtener todos los productos",
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     * response=200,
     * description="Lista de productos",
     * @OA\JsonContent(
     * type="array",
     * @OA\Items(
     * @OA\Property(property="id", type="integer"),
     * @OA\Property(property="nombre", type="string"),
     * @OA\Property(property="descripcion", type="string", nullable=true),
     * @OA\Property(property="imagen_path", type="string", nullable=true),
     * @OA\Property(property="precio", type="number", format="float"),
     * @OA\Property(property="stock", type="integer"),
     * @OA\Property(property="sku", type="string", nullable=true),
     * @OA\Property(property="categoria_id", type="integer", nullable=true),
     * @OA\Property(property="activo", type="boolean")
     * )
     * )
     * )
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json($this->service->findAll());
    }

    /**
     * @OA\Post(
     * path="/api/Catalog_productos/productos",
     * tags={"Productos"},
     * summary="Crear un nuevo producto",
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * @OA\Property(property="nombre", type="string", example="Cera para Cabello"),
     * @OA\Property(property="descripcion", type="string", example="Cera de fijación fuerte"),
     * @OA\Property(property="imagen_path", type="string", nullable=true, example="productos/cera.jpg"),
     * @OA\Property(property="precio", type="number", format="float", example=150.50),
     * @OA\Property(property="stock", type="integer", example=100),
     * @OA\Property(property="sku", type="string", example="CERA-003"),
     * @OA\Property(property="categoria_id", type="integer", example=1),
     * @OA\Property(property="activo", type="boolean", example=true)
     * )
     * ),
     * @OA\Response(
     * response=201,
     * description="Producto creado exitosamente.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Producto creado exitosamente")
     * )
     * ),
     * @OA\Response(response=422, description="Error de validación")
     * )
     */
    public function store(StoreProductoRequest $request): JsonResponse
    {
        $data = $request->validated();
        $producto = new Producto(
            null,
            $data['nombre'],
            $data['descripcion'] ?? null,
            $data['imagen_path'] ?? null,
            (float) $data['precio'],
            (int) $data['stock'],
            $data['sku'] ?? null,
            $data['categoria_id'] ?? null,
            $data['activo'] ?? true
        );

        $this->service->save($producto);

        // AQUÍ ESTÁ EL CAMBIO CLAVE: Devolver un JSON consistente.
        return response()->json([
            'message' => 'Producto creado exitosamente'
        ], 201);
    }

    /**
     * @OA\Get(
     * path="/api/Catalog_productos/productos/{id}",
     * tags={"Productos"},
     * summary="Obtener un producto por ID",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Detalles del producto"),
     * @OA\Response(response=404, description="Producto no encontrado")
     * )
     */
    public function show(int $id): JsonResponse
    {
        $producto = $this->service->findById($id);
        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }
        return response()->json($producto);
    }

    /**
     * @OA\Put(
     * path="/api/Catalog_productos/productos/{id}",
     * tags={"Productos"},
     * summary="Actualizar un producto",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * @OA\Property(property="nombre", type="string", example="Cera para Cabello Mate"),
     * @OA\Property(property="precio", type="number", format="float", example=160.00)
     * )
     * ),
     * @OA\Response(response=204, description="Producto actualizado"),
     * @OA\Response(response=404, description="Producto no encontrado")
     * )
     */
    public function update(UpdateProductoRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $existingProducto = $this->service->findById($id);
        
        if (!$existingProducto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        $producto = new Producto(
            $id,
            $data['nombre'] ?? $existingProducto->nombre,
            $data['descripcion'] ?? $existingProducto->descripcion,
            $data['imagen_path'] ?? $existingProducto->imagen_path,
            isset($data['precio']) ? (float) $data['precio'] : $existingProducto->precio,
            isset($data['stock']) ? (int) $data['stock'] : $existingProducto->stock,
            $data['sku'] ?? $existingProducto->sku,
            $data['categoria_id'] ?? $existingProducto->categoria_id,
            $data['activo'] ?? $existingProducto->activo
        );
        
        $this->service->update($id, $producto);
        return response()->json(null, 204);
    }

    /**
     * @OA\Delete(
     * path="/api/Catalog_productos/productos/{id}",
     * tags={"Productos"},
     * summary="Eliminar un producto (Soft Delete)",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=204, description="Producto eliminado"),
     * @OA\Response(response=404, description="Producto no encontrado")
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $this->service->delete($id);
        return response()->json(null, 204);
    }
}