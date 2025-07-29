<?php

namespace Src\Admin\personal\infrastructure\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Src\Admin\personal\application\PersonalService;
use Src\Admin\personal\domain\Exception\UsuarioYaEsEmpleadoException;
use Src\Admin\personal\domain\Exception\PersonalNotFoundException;
use OpenApi\Annotations as OA;

class PromocionController extends Controller
{
    public function __construct(private readonly PersonalService $service) {}

    /**
     * @OA\Post(
     * path="/api/Admin_personal/usuarios/{usuarioId}/promover-a-empleado",
     * tags={"Promociones Personal"},
     * summary="Promover cliente a empleado",
     * description="Promueve un cliente a empleado en la sucursal del administrador",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     * name="usuarioId",
     * in="path",
     * required=true,
     * @OA\Schema(type="integer"),
     * description="ID del usuario cliente a promover"
     * ),
     * @OA\RequestBody(
     * required=false,
     * @OA\JsonContent(
     * @OA\Property(property="sucursal_asignada_id", type="integer", example=1, description="ID de la sucursal (solo para GERENTE)")
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Usuario promovido exitosamente",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Usuario promovido a empleado exitosamente.")
     * )
     * ),
     * @OA\Response(
     * response=409,
     * description="Usuario ya es empleado",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="El usuario ya es empleado.")
     * )
     * ),
     * @OA\Response(response=403, description="Acceso denegado"),
     * @OA\Response(response=404, description="Usuario no encontrado")
     * )
     */
    public function promoverClienteAEmpleado(Request $request, int $usuarioId): JsonResponse
    {
        try {
            // Obtener la sucursal asignada del administrador actual
            $sucursalAsignadaId = $request->input('sucursal_asignada_id');

            // Si no se proporciona sucursal_asignada_id, usar la del administrador actual
            if (!$sucursalAsignadaId) {
                $user = Auth::user();
                // Aquí deberías obtener la sucursal del administrador actual
                // Por ahora usaremos un valor por defecto
                $sucursalAsignadaId = 1; // TODO: Implementar lógica para obtener sucursal del admin
            }

            $this->service->promoverClienteAEmpleado($usuarioId, $sucursalAsignadaId);

            return response()->json([
                'message' => 'Usuario promovido a empleado exitosamente.'
            ], 200);
        } catch (UsuarioYaEsEmpleadoException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 409);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * @OA\Post(
     * path="/api/Admin_personal/personal/{personalId}/promover-a-admin",
     * tags={"Promociones Personal"},
     * summary="Promover empleado a administrador de sucursal",
     * description="Promueve un empleado a administrador de sucursal (solo GERENTE)",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     * name="personalId",
     * in="path",
     * required=true,
     * @OA\Schema(type="integer"),
     * description="ID del registro de personal a promover"
     * ),
     * @OA\Response(
     * response=200,
     * description="Empleado promovido exitosamente",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Empleado promovido a Administrador de Sucursal exitosamente.")
     * )
     * ),
     * @OA\Response(
     * response=403,
     * description="Acceso denegado - Solo GERENTE puede realizar esta acción",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="No tienes permisos para realizar esta acción.")
     * )
     * ),
     * @OA\Response(
     * response=404,
     * description="Personal no encontrado",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Personal no encontrado.")
     * )
     * )
     * )
     */
    public function promoverEmpleadoAAdmin(int $personalId): JsonResponse
    {
        try {
            $this->service->promoverEmpleadoAAdmin($personalId);

            return response()->json([
                'message' => 'Empleado promovido a Administrador de Sucursal exitosamente.'
            ], 200);
        } catch (PersonalNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
