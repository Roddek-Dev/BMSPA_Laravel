<?php

namespace Src\Client\direcciones\infrastructure\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use Src\Client\direcciones\application\DireccionService;
use Src\Client\direcciones\domain\Entities\Direccion;
use Src\Client\direcciones\infrastructure\Http\Requests\StoreDireccionRequest;
use Src\Client\direcciones\infrastructure\Http\Requests\UpdateDireccionRequest;
use Src\Client\usuarios\infrastructure\Persistence\Eloquent\UsuarioModel; 

class DireccionController extends Controller
{
    public function __construct(private readonly DireccionService $service)
    {
    }

    /**
     * @OA\Get(
     * path="/api/Client_direcciones/direcciones",
     * tags={"Direcciones de Cliente"},
     * summary="Obtener todas las direcciones del cliente autenticado",
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     * response=200,
     * description="Lista de direcciones del cliente.",
     * @OA\JsonContent(
     * type="array",
     * @OA\Items(
     * @OA\Property(property="id", type="integer", readOnly=true, example=1),
     * @OA\Property(property="direccionable_id", type="integer", readOnly=true, example=5),
     * @OA\Property(property="direccionable_type", type="string", readOnly=true, example="Src\Client\usuarios\infrastructure\Persistence\Eloquent\UsuarioModel"),
     * @OA\Property(property="direccion", type="string", example="Calle Falsa 123"),
     * @OA\Property(property="colonia", type="string", example="Centro"),
     * @OA\Property(property="codigo_postal", type="string", example="150001"),
     * @OA\Property(property="ciudad", type="string", example="Duitama"),
     * @OA\Property(property="estado", type="string", example="Boyacá"),
     * @OA\Property(property="referencias", type="string", nullable=true, example="Casa de dos pisos"),
     * @OA\Property(property="es_predeterminada", type="boolean", example=true)
     * )
     * )
     * )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $clientId = $request->user()->id;
        $direcciones = $this->service->findAllByOwner(UsuarioModel::class, $clientId);
        return response()->json($direcciones);
    }

    /**
     * @OA\Post(
     * path="/api/Client_direcciones/direcciones",
     * tags={"Direcciones de Cliente"},
     * summary="Crear una nueva dirección para el cliente",
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(
     * required=true,
     * description="Datos de la nueva dirección",
     * @OA\JsonContent(
     * required={"direccion", "colonia", "codigo_postal", "ciudad", "estado"},
     * @OA\Property(property="direccion", type="string", example="Avenida Principal 456"),
     * @OA\Property(property="colonia", type="string", example="El Sol"),
     * @OA\Property(property="codigo_postal", type="string", example="150002"),
     * @OA\Property(property="ciudad", type="string", example="Duitama"),
     * @OA\Property(property="estado", type="string", example="Boyacá"),
     * @OA\Property(property="referencias", type="string", nullable=true, example="Frente al parque"),
     * @OA\Property(property="es_predeterminada", type="boolean", example=false)
     * )
     * ),
     * @OA\Response(response=201, description="Dirección creada exitosamente."),
     * @OA\Response(response=422, description="Error de validación de datos.")
     * )
     */
    public function store(StoreDireccionRequest $request): JsonResponse
    {
        $data = $request->validated();
        $clientId = $request->user()->id;
        
        $direccion = new Direccion(
            null,
            $clientId,
            UsuarioModel::class,
            $data['direccion'],
            $data['colonia'],
            $data['codigo_postal'],
            $data['ciudad'],
            $data['estado'],
            $data['referencias'] ?? null,
            $data['es_predeterminada'] ?? false
        );
        
        $this->service->save($direccion);
        return response()->json(null, 201);
    }

    /**
     * @OA\Get(
     * path="/api/Client_direcciones/direcciones/{id}",
     * tags={"Direcciones de Cliente"},
     * summary="Obtener una dirección por ID",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(
     * response=200,
     * description="Detalles de la dirección.",
     * @OA\JsonContent(
     * @OA\Property(property="id", type="integer", readOnly=true, example=1),
     * @OA\Property(property="direccionable_id", type="integer", readOnly=true, example=5),
     * @OA\Property(property="direccionable_type", type="string", readOnly=true, example="Src\Client\usuarios\infrastructure\Persistence\Eloquent\UsuarioModel"),
     * @OA\Property(property="direccion", type="string", example="Calle Falsa 123"),
     * @OA\Property(property="colonia", type="string", example="Centro"),
     * @OA\Property(property="codigo_postal", type="string", example="150001"),
     * @OA\Property(property="ciudad", type="string", example="Duitama"),
     * @OA\Property(property="estado", type="string", example="Boyacá"),
     * @OA\Property(property="referencias", type="string", nullable=true, example="Casa de dos pisos"),
     * @OA\Property(property="es_predeterminada", type="boolean", example=true)
     * )
     * ),
     * @OA\Response(response=404, description="Dirección no encontrada.")
     * )
     */
    public function show(int $id): JsonResponse
    {
        $direccion = $this->service->findById($id);
        return response()->json($direccion);
    }

    /**
     * @OA\Put(
     * path="/api/Client_direcciones/direcciones/{id}",
     * tags={"Direcciones de Cliente"},
     * summary="Actualizar una dirección existente",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\RequestBody(
     * required=true,
     * description="Datos a actualizar de la dirección",
     * @OA\JsonContent(
     * @OA\Property(property="direccion", type="string", example="Calle Actualizada 789"),
     * @OA\Property(property="colonia", type="string", example="La Luna"),
     * @OA\Property(property="codigo_postal", type="string", example="150003"),
     * @OA\Property(property="ciudad", type="string", example="Duitama"),
     * @OA\Property(property="estado", type="string", example="Boyacá"),
     * @OA\Property(property="referencias", type="string", nullable=true, example="Edificio alto, apartamento 101"),
     * @OA\Property(property="es_predeterminada", type="boolean", example=true)
     * )
     * ),
     * @OA\Response(response=204, description="Dirección actualizada exitosamente."),
     * @OA\Response(response=404, description="Dirección no encontrada."),
     * @OA\Response(response=422, description="Error de validación de datos.")
     * )
     */
    public function update(UpdateDireccionRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $currentDireccion = $this->service->findById($id);

        if (!$currentDireccion) {
            return response()->json(null, 404);
        }
        
        $direccion = new Direccion(
            $id,
            $currentDireccion->direccionable_id,
            $currentDireccion->direccionable_type,
            $data['direccion'] ?? $currentDireccion->direccion,
            $data['colonia'] ?? $currentDireccion->colonia,
            $data['codigo_postal'] ?? $currentDireccion->codigo_postal,
            $data['ciudad'] ?? $currentDireccion->ciudad,
            $data['estado'] ?? $currentDireccion->estado,
            $data['referencias'] ?? $currentDireccion->referencias,
            $data['es_predeterminada'] ?? $currentDireccion->es_predeterminada
        );
        
        $this->service->update($id, $direccion);
        return response()->json(null, 204);
    }

    /**
     * @OA\Delete(
     * path="/api/Client_direcciones/direcciones/{id}",
     * tags={"Direcciones de Cliente"},
     * summary="Eliminar una dirección",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=204, description="Dirección eliminada exitosamente."),
     * @OA\Response(response=404, description="Dirección no encontrada.")
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $this->service->delete($id);
        return response()->json(null, 204);
    }
    
    /**
     * @OA\Post(
     * path="/api/Client_direcciones/direcciones/{id}/default",
     * tags={"Direcciones de Cliente"},
     * summary="Establecer una dirección como predeterminada",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=204, description="Dirección establecida como predeterminada."),
     * @OA\Response(response=404, description="Dirección no encontrada.")
     * )
     */
    public function setAsDefault(Request $request, int $id): JsonResponse
    {
        $clientId = $request->user()->id;
        $this->service->setAsDefault($id, UsuarioModel::class, $clientId);
        return response()->json(null, 204);
    }
}