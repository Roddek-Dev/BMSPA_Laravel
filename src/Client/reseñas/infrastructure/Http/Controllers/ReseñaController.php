<?php

namespace Src\Client\reseñas\infrastructure\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Client\reseñas\application\ReseñaService;
use Src\Client\reseñas\domain\Entities\Reseña;
use Src\Client\reseñas\infrastructure\Http\Requests\StoreReseñaRequest;
use Src\Client\reseñas\infrastructure\Http\Requests\UpdateReseñaRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Src\Admin\sucursales\infrastructure\Models\SucursalModel;
use Src\Catalog\servicios\infrastructure\Models\ServicioModel;
use Src\Catalog\productos\infrastructure\Models\ProductoModel;
use OpenApi\Annotations as OA;
use Carbon\Carbon;
use Src\Client\reseñas\infrastructure\Models\ReseñaModel;

class ReseñaController extends Controller
{
    public function __construct(private readonly ReseñaService $service) {}

    /**
     * @OA\Get(
     * path="/api/Client_reseñas/reviews/public",
     * tags={"Reseñas (Público)"},
     * summary="Obtener todas las reseñas aprobadas de un item",
     * @OA\Parameter(name="type", in="query", required=true, description="Tipo de item a reseñar", @OA\Schema(type="string", enum={"sucursal", "servicio", "producto"})),
     * @OA\Parameter(name="id", in="query", required=true, description="ID del item a reseñar", @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Lista de reseñas públicas.")
     * )
     */
    public function getPublicReviews(Request $request): JsonResponse
    {
        $validated = Validator::make($request->query(), [
            'type' => ['required', 'string', Rule::in(['sucursal', 'servicio', 'producto'])],
            'id' => 'required|integer',
        ])->validate();

        $typeMap = [
            'sucursal' => SucursalModel::class,
            'servicio' => ServicioModel::class,
            'producto' => ProductoModel::class,
        ];

        $itemTypeClass = $typeMap[$validated['type']];
        $itemId = $validated['id'];

        $reseñas = $this->service->findAllApprovedByItem($itemTypeClass, $itemId);
        return response()->json($reseñas);
    }

    /**
     * @OA\Get(
     * path="/api/Client_reseñas/reviews",
     * tags={"Reseñas (Cliente)"},
     * summary="Obtener mis reseñas",
     * security={{"bearerAuth":{}}},
     * @OA\Response(response=200, description="Lista de mis reseñas.")
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $clientId = $request->user()->id;
        $reseñas = $this->service->findAllByClient($clientId);
        return response()->json($reseñas);
    }

    /**
     * @OA\Post(
     * path="/api/Client_reseñas/reviews",
     * tags={"Reseñas (Cliente)"},
     * summary="Crear una nueva reseña (solo clientes)",
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(
     * required=true,
     * description="Datos para crear la nueva reseña",
     * @OA\JsonContent(
     * @OA\Property(property="reseñable_type", type="string", enum={"sucursal", "servicio", "producto"}, example="producto"),
     * @OA\Property(property="reseñable_id", type="integer", example=1),
     * @OA\Property(property="calificacion", type="integer", example=5, description="Calificación de 1 a 5"),
     * @OA\Property(property="comentario", type="string", example="¡Excelente producto, lo recomiendo!")
     * )
     * ),
     * @OA\Response(response=201, description="Reseña creada y pendiente de aprobación."),
     * @OA\Response(response=403, description="No autorizado (ej. si un admin intenta crear una reseña)."),
     * @OA\Response(response=422, description="Error de validación.")
     * )
     */
    public function store(StoreReseñaRequest $request): JsonResponse
    {
        if ($request->user()->rol !== 'CLIENTE') {
            return response()->json(['message' => 'Solo los clientes pueden crear reseñas.'], 403);
        }
        $data = $request->validated();
        $typeMap = [
            'sucursal' => SucursalModel::class,
            'servicio' => ServicioModel::class,
            'producto' => ProductoModel::class,
        ];
        $reseñableClass = $typeMap[$data['reseñable_type']];
        $validator = Validator::make($data, [
            'reseñable_id' => [Rule::exists($reseñableClass, 'id')->whereNull('deleted_at')]
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'El ID proporcionado no es válido para el tipo de reseña especificado.',
                'errors' => $validator->errors()
            ], 422);
        }
        $reseña = new Reseña(null, $request->user()->id, $reseñableClass, $data['reseñable_id'], $data['calificacion'], $data['comentario'] ?? null, false, Carbon::now()->toDateTimeString());
        $this->service->save($reseña);
        return response()->json(['message' => 'Reseña creada y enviada para aprobación'], 201);
    }

    /**
     * @OA\Put(
     * path="/api/Client_reseñas/reviews/{id}",
     * tags={"Reseñas (Cliente)"},
     * summary="Actualizar mi reseña (solo clientes)",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\RequestBody(
     * required=true,
     * description="Campos a actualizar de la reseña",
     * @OA\JsonContent(
     * @OA\Property(property="calificacion", type="integer", example=4),
     * @OA\Property(property="comentario", type="string", example="Este es mi comentario actualizado.")
     * )
     * ),
     * @OA\Response(response=204, description="Reseña actualizada y pendiente de reaprobación."),
     * @OA\Response(response=403, description="No autorizado."),
     * @OA\Response(response=404, description="Reseña no encontrada.")
     * )
     */
    public function update(UpdateReseñaRequest $request, $id): JsonResponse
    {
        $reseñaId = (int) $request->route('id');
        $reseñaModel = $this->service->findById($reseñaId);

        if (!$reseñaModel) {
            return response()->json(['message' => 'Reseña no encontrada'], 404);
        }
        if ($reseñaModel->cliente_usuario_id !== $request->user()->id) {
            return response()->json(['message' => 'No autorizado para actualizar esta reseña'], 403);
        }
        $data = $request->validated();
        $updatedReseña = new Reseña($reseñaId, $reseñaModel->cliente_usuario_id, $reseñaModel->reseñable_type, $reseñaModel->reseñable_id, $data['calificacion'] ?? $reseñaModel->calificacion, $data['comentario'] ?? $reseñaModel->comentario, false, $reseñaModel->fecha_reseña);
        $this->service->update($reseñaId, $updatedReseña);
        return response()->json(null, 204);
    }

    /**
     * @OA\Delete(
     * path="/api/Client_reseñas/reviews/{id}",
     * tags={"Reseñas (Cliente)"},
     * summary="Eliminar mi reseña (solo clientes)",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=204, description="Reseña eliminada."),
     * @OA\Response(response=403, description="No autorizado."),
     * @OA\Response(response=404, description="Reseña no encontrada.")
     * )
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        $reseñaId = (int) $request->route('id');
        $reseñaModel = $this->service->findById($reseñaId);

        if (!$reseñaModel) {
            return response()->json(['message' => 'Reseña no encontrada'], 404);
        }
        if ($reseñaModel->cliente_usuario_id !== $request->user()->id) {
            return response()->json(['message' => 'No autorizado para eliminar esta reseña'], 403);
        }
        $this->service->delete($reseñaId);
        return response()->json(null, 204);
    }

    /**
     * @OA\Put(
     * path="/api/Client_reseñas/reviews/{reseña}/aprobar",
     * tags={"Reseñas (Admin)"},
     * summary="Aprobar una reseña pendiente (Admins)",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="reseña", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=204, description="Reseña aprobada exitosamente."),
     * @OA\Response(response=404, description="Reseña no encontrada.")
     * )
     */
    public function approve(Request $request, ReseñaModel $reseña): JsonResponse
    {
        // No necesitas buscar la reseña, Laravel ya lo hizo por ti.
        // Si no la encuentra, ya habría devuelto un 404.

        $approvedReseña = new Reseña(
            $reseña->id,
            $reseña->cliente_usuario_id,
            $reseña->reseñable_type,
            $reseña->reseñable_id,
            $reseña->calificacion,
            $reseña->comentario,
            true, // <-- El cambio clave: se aprueba la reseña
            $reseña->fecha_reseña->toDateTimeString()
        );

        $this->service->update($reseña->id, $approvedReseña);

                 return response()->json(null, 204);
     }
     
     /**
      * @OA\Get(
      * path="/api/Client_reseñas/reviews/pending",
      * tags={"Reseñas (Admin)"},
      * summary="Obtener todas las reseñas pendientes de aprobación (Solo ADMIN_SUCURSAL y GERENTE)",
      * security={{"bearerAuth":{}}},
      * @OA\Response(
      * response=200,
      * description="Lista de reseñas pendientes de aprobación",
      * @OA\JsonContent(type="array", @OA\Items(
      * @OA\Property(property="id", type="integer"),
      * @OA\Property(property="cliente_usuario_id", type="integer"),
      * @OA\Property(property="reseñable_type", type="string"),
      * @OA\Property(property="reseñable_id", type="integer"),
      * @OA\Property(property="calificacion", type="integer"),
      * @OA\Property(property="comentario", type="string", nullable=true),
      * @OA\Property(property="aprobada", type="boolean"),
      * @OA\Property(property="fecha_reseña", type="string", format="date-time")
      * ))
      * ),
      * @OA\Response(response=403, description="No autorizado - Solo ADMIN_SUCURSAL y GERENTE")
      * )
      */
     public function getPendingReviews(Request $request): JsonResponse
     {
         // Verificar que el usuario tiene permisos de administrador
         $user = $request->user();
         if (!in_array($user->rol, ['ADMIN_SUCURSAL', 'GERENTE'])) {
             return response()->json([
                 'message' => 'No tienes permisos para ver reseñas pendientes de aprobación'
             ], 403);
         }
         
         $reseñas = $this->service->findAllPendingApproval();
         return response()->json($reseñas);
     }
 }
