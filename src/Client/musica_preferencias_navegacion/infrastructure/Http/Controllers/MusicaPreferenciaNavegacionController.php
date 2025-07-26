<?php

namespace Src\Client\musica_preferencias_navegacion\infrastructure\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Src\Client\musica_preferencias_navegacion\application\MusicaPreferenciaNavegacionService;
use Src\Client\musica_preferencias_navegacion\domain\Entities\MusicaPreferenciaNavegacion;
use Src\Client\musica_preferencias_navegacion\infrastructure\Http\Requests\StoreMusicaPreferenciaNavegacionRequest;
use Src\Client\musica_preferencias_navegacion\infrastructure\Http\Requests\UpdateMusicaPreferenciaNavegacionRequest;
use OpenApi\Annotations as OA;

class MusicaPreferenciaNavegacionController extends Controller
{
    public function __construct(private readonly MusicaPreferenciaNavegacionService $service)
    {
    }

    /**
     * @OA\Get(
     * path="/api/Client_musica_preferencias/preferencias",
     * tags={"Preferencias de Música"},
     * summary="Obtener todas las preferencias de música",
     * @OA\Response(response=200, description="Lista de preferencias de música")
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json($this->service->findAll());
    }

    /**
     * @OA\Post(
     * path="/api/Client_musica_preferencias/preferencias",
     * tags={"Preferencias de Música"},
     * summary="Crear una nueva preferencia de música",
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * @OA\Property(property="nombre_opcion", type="string", example="Rock Clásico"),
     * @OA\Property(property="descripcion", type="string", example="Lo mejor de los 70s y 80s."),
     * @OA\Property(property="stream_url_ejemplo", type="string", format="url", example="https://example.com/stream/rock.mp3"),
     * @OA\Property(property="activo", type="boolean", example=true)
     * )
     * ),
     * @OA\Response(
     * response=201,
     * description="Preferencia creada exitosamente.",
     * @OA\JsonContent(@OA\Property(property="message", type="string", example="Preferencia de música creada exitosamente"))
     * ),
     * @OA\Response(response=422, description="Error de validación")
     * )
     */
    public function store(StoreMusicaPreferenciaNavegacionRequest $request): JsonResponse
    {
        $data = $request->validated();
        $preferencia = new MusicaPreferenciaNavegacion(
            null,
            $data['nombre_opcion'],
            $data['descripcion'] ?? null,
            $data['stream_url_ejemplo'] ?? null,
            $data['activo'] ?? true
        );
        $this->service->save($preferencia);
        return response()->json(['message' => 'Preferencia de música creada exitosamente'], 201);
    }

    /**
     * @OA\Get(
     * path="/api/Client_musica_preferencias/preferencias/{id}",
     * tags={"Preferencias de Música"},
     * summary="Obtener una preferencia por ID",
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Detalles de la preferencia"),
     * @OA\Response(response=404, description="Preferencia no encontrada")
     * )
     */
    public function show(int $id): JsonResponse
    {
        $preferencia = $this->service->findById($id);
        if (!$preferencia) {
            return response()->json(['message' => 'Preferencia no encontrada'], 404);
        }
        return response()->json($preferencia);
    }

    /**
     * @OA\Put(
     * path="/api/Client_musica_preferencias/preferencias/{id}",
     * tags={"Preferencias de Música"},
     * summary="Actualizar una preferencia de música",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * @OA\Property(property="nombre_opcion", type="string", example="Pop Latino"),
     * @OA\Property(property="activo", type="boolean", example=false)
     * )
     * ),
     * @OA\Response(response=204, description="Preferencia actualizada"),
     * @OA\Response(response=404, description="Preferencia no encontrada")
     * )
     */
    public function update(UpdateMusicaPreferenciaNavegacionRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $existing = $this->service->findById($id);

        if (!$existing) {
            return response()->json(['message' => 'Preferencia no encontrada'], 404);
        }

        $preferencia = new MusicaPreferenciaNavegacion(
            $id,
            $data['nombre_opcion'] ?? $existing->nombre_opcion,
            $data['descripcion'] ?? $existing->descripcion,
            $data['stream_url_ejemplo'] ?? $existing->stream_url_ejemplo,
            $data['activo'] ?? $existing->activo
        );
        
        $this->service->update($id, $preferencia);
        return response()->json(null, 204);
    }

    /**
     * @OA\Delete(
     * path="/api/Client_musica_preferencias/preferencias/{id}",
     * tags={"Preferencias de Música"},
     * summary="Eliminar una preferencia de música",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=204, description="Preferencia eliminada"),
     * @OA\Response(response=404, description="Preferencia no encontrada")
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $this->service->delete($id);
        return response()->json(null, 204);
    }
}