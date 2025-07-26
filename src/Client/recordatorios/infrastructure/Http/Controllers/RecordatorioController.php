<?php

namespace Src\Client\recordatorios\infrastructure\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Src\Client\recordatorios\application\RecordatorioService;
use Src\Client\recordatorios\domain\Entities\Recordatorio;
use Src\Client\recordatorios\infrastructure\Http\Requests\StoreRecordatorioRequest;
use Src\Client\recordatorios\infrastructure\Http\Requests\UpdateRecordatorioRequest;
use OpenApi\Annotations as OA;

class RecordatorioController extends Controller
{
    public function __construct(private readonly RecordatorioService $service)
    {
    }

    /**
     * @OA\Get(
     * path="/api/Client_recordatorios/recordatorios",
     * tags={"Recordatorios"},
     * summary="Obtener todos los recordatorios (protegido)",
     * security={{"bearerAuth":{}}},
     * @OA\Response(response=200, description="Lista de recordatorios")
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json($this->service->findAll());
    }

   /**
     * @OA\Post(
     * path="/api/Client_recordatorios/recordatorios",
     * tags={"Recordatorios"},
     * summary="Crear un nuevo recordatorio",
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * @OA\Property(property="usuario_id", type="integer", example=1),
     * @OA\Property(property="agendamiento_id", type="integer", example=1),
     * @OA\Property(property="titulo", type="string", example="Recordatorio de Cita"),
     * @OA\Property(property="descripcion", type="string", example="Tu cita es mañana a las 10 AM."),
     * @OA\Property(property="fecha_hora_recordatorio", type="string", format="date-time", example="2025-12-24 10:00:00")
     * )
     * ),
     * @OA\Response(
     * response=201,
     * description="Recordatorio creado exitosamente.",
     * @OA\JsonContent(@OA\Property(property="message", type="string", example="Recordatorio creado exitosamente"))
     * ),
     * @OA\Response(
     * response=409, 
     * description="Conflicto de datos. Usualmente una clave foránea (usuario_id, agendamiento_id) no existe.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Error al crear el recordatorio. Verifique que los IDs relacionados existan."),
     * @OA\Property(property="error", type="string", example="SQLSTATE[23000]: Integrity constraint violation...")
     * )
     * ),
     * @OA\Response(response=422, description="Error de validación de datos.")
     * )
     */
    public function store(StoreRecordatorioRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            
            $recordatorio = new Recordatorio(
                null,
                (int) $data['usuario_id'],
                isset($data['agendamiento_id']) ? (int) $data['agendamiento_id'] : null,
                $data['titulo'],
                $data['descripcion'] ?? null,
                $data['fecha_hora_recordatorio'],
                $data['canal_notificacion'] ?? 'EMAIL',
                $data['enviado'] ?? false,
                $data['fecha_envio'] ?? null,
                $data['activo'] ?? true,
                $data['fijado'] ?? false
            );

            $this->service->save($recordatorio);

            return response()->json(['message' => 'Recordatorio creado exitosamente'], 201);

        } catch (QueryException $e) {
            // AQUÍ ESTÁ LA MAGIA DE LA DEPURACIÓN
            $errorCode = $e->errorInfo[1];
            
            // 1452 es el código de error de MySQL para violación de clave foránea
            if ($errorCode == 1452) {
                $errorMessage = 'Error de clave foránea: Asegúrese de que el `usuario_id` y/o `agendamiento_id` que está enviando realmente existan en la base de datos.';
            } else {
                $errorMessage = 'Error de base de datos al crear el recordatorio.';
            }

            Log::error('Error de base de datos al crear recordatorio: '.$e->getMessage());

            return response()->json([
                'message' => $errorMessage,
                'error_code' => $errorCode,
                'sql_error' => $e->getMessage() // Devolvemos el mensaje de SQL completo
            ], 409); // 409 Conflict

        } catch (\Throwable $e) {
            Log::error('Error inesperado al crear recordatorio: '.$e->getMessage());
            return response()->json([
                'message' => 'Ocurrió un error inesperado en el servidor.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    /**
     * @OA\Get(
     * path="/api/Client_recordatorios/recordatorios/{id}",
     * tags={"Recordatorios"},
     * summary="Obtener un recordatorio por ID",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Detalles del recordatorio"),
     * @OA\Response(response=404, description="Recordatorio no encontrado")
     * )
     */
    public function show(int $id): JsonResponse
    {
        $recordatorio = $this->service->findById($id);
        if (!$recordatorio) {
            return response()->json(['message' => 'Recordatorio no encontrado'], 404);
        }
        return response()->json($recordatorio);
    }

    /**
     * @OA\Put(
     * path="/api/Client_recordatorios/recordatorios/{id}",
     * tags={"Recordatorios"},
     * summary="Actualizar un recordatorio",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * @OA\Property(property="titulo", type="string", example="Cita de seguimiento"),
     * @OA\Property(property="activo", type="boolean", example=false)
     * )
     * ),
     * @OA\Response(response=204, description="Recordatorio actualizado"),
     * @OA\Response(response=404, description="Recordatorio no encontrado")
     * )
     */
    public function update(UpdateRecordatorioRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $existing = $this->service->findById($id);

        if (!$existing) {
            return response()->json(['message' => 'Recordatorio no encontrado'], 404);
        }

        // CORRECCIÓN: Asegurar el tipo de dato correcto en la actualización.
        $recordatorio = new Recordatorio(
            $id,
            isset($data['usuario_id']) ? (int) $data['usuario_id'] : $existing->usuario_id,
            isset($data['agendamiento_id']) ? (int) $data['agendamiento_id'] : $existing->agendamiento_id,
            $data['titulo'] ?? $existing->titulo,
            $data['descripcion'] ?? $existing->descripcion,
            $data['fecha_hora_recordatorio'] ?? $existing->fecha_hora_recordatorio,
            $data['canal_notificacion'] ?? $existing->canal_notificacion,
            $data['enviado'] ?? $existing->enviado,
            $data['fecha_envio'] ?? $existing->fecha_envio,
            $data['activo'] ?? $existing->activo,
            $data['fijado'] ?? $existing->fijado
        );
        
        $this->service->update($id, $recordatorio);
        return response()->json(null, 204);
    }

    /**
     * @OA\Delete(
     * path="/api/Client_recordatorios/recordatorios/{id}",
     * tags={"Recordatorios"},
     * summary="Eliminar un recordatorio",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=204, description="Recordatorio eliminado"),
     * @OA\Response(response=404, description="Recordatorio no encontrado")
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $this->service->delete($id);
        return response()->json(null, 204);
    }
}