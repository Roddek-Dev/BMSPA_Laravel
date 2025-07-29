<?php

declare(strict_types=1);

namespace Src\Client\usuarios\infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Src\Client\usuarios\application\Profile\Command\UpdateProfileCommand;
use Src\Client\usuarios\application\Profile\Command\ChangePasswordCommand;
use Src\Client\usuarios\application\Profile\Handler\UpdateProfileHandler;
use Src\Client\usuarios\application\Profile\Handler\ChangePasswordHandler;
use Src\Client\usuarios\domain\Repositories\UsuarioRepositoryInterface;
use Src\Client\usuarios\domain\ValueObjects\UsuarioId;
use Src\Client\usuarios\domain\Exception\UsuarioNotFoundException;
use Src\Client\usuarios\domain\Exception\InvalidCredentialsException;

class UserController extends Controller
{
    public function __construct(
        private UpdateProfileHandler $updateProfileHandler,
        private ChangePasswordHandler $changePasswordHandler,
        private UsuarioRepositoryInterface $repository
    ) {}

    /**
     * @OA\Get(
     * path="/api/Client_usuarios/profile",
     * tags={"Usuario"},
     * summary="Obtener perfil del usuario autenticado",
     * description="Retorna la información del perfil del usuario actualmente autenticado.",
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     * response=200,
     * description="Perfil obtenido exitosamente",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Perfil obtenido exitosamente"),
     * @OA\Property(property="data", type="object",
     * @OA\Property(property="id", type="integer", example=1),
     * @OA\Property(property="nombre", type="string", example="Juan Pérez"),
     * @OA\Property(property="email", type="string", format="email", example="juan.perez@example.com"),
     * @OA\Property(property="telefono", type="string", example="3101234567"),
     * @OA\Property(property="rol", type="string", example="CLIENTE"),
     * @OA\Property(property="activo", type="boolean", example=true),
     * @OA\Property(property="imagen_path", type="string", nullable=true, example="uploads/avatars/user1.jpg")
     * )
     * )
     * ),
     * @OA\Response(
     * response=401,
     * description="No autenticado"
     * )
     * )
     */
    public function profile(Request $request): JsonResponse
    {
        try {
            $userId = auth('api')->id();
            $usuarioId = new UsuarioId($userId);
            $usuario = $this->repository->findById($usuarioId);

            if (!$usuario) {
                return response()->json([
                    'message' => 'Usuario no encontrado'
                ], 404);
            }

            return response()->json([
                'message' => 'Perfil obtenido exitosamente',
                'data' => [
                    'id' => $usuario->id()->value(),
                    'nombre' => $usuario->nombre()->value(),
                    'email' => $usuario->email()->value(),
                    'telefono' => $usuario->telefono(),
                    'rol' => $usuario->rol(),
                    'activo' => $usuario->activo(),
                    'imagen_path' => $usuario->imagenPath()
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error al obtener perfil: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error al obtener el perfil'
            ], 500);
        }
    }

    /**
     * @OA\Put(
     * path="/api/Client_usuarios/profile",
     * tags={"Usuario"},
     * summary="Actualizar perfil del usuario",
     * description="Actualiza la información del perfil del usuario autenticado.",
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(
     * required=true,
     * description="Datos del perfil a actualizar",
     * @OA\JsonContent(
     * @OA\Property(property="nombre", type="string", example="Juan Carlos Pérez"),
     * @OA\Property(property="telefono", type="string", example="3101234568"),
     * @OA\Property(property="imagen_path", type="string", example="uploads/avatars/new-avatar.jpg")
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Perfil actualizado exitosamente",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Perfil actualizado exitosamente"),
     * @OA\Property(property="data", type="object",
     * @OA\Property(property="id", type="integer", example=1),
     * @OA\Property(property="nombre", type="string", example="Juan Carlos Pérez"),
     * @OA\Property(property="email", type="string", format="email", example="juan.perez@example.com"),
     * @OA\Property(property="telefono", type="string", example="3101234568"),
     * @OA\Property(property="imagen_path", type="string", example="uploads/avatars/new-avatar.jpg")
     * )
     * )
     * ),
     * @OA\Response(
     * response=422,
     * description="Error de validación"
     * ),
     * @OA\Response(
     * response=401,
     * description="No autenticado"
     * )
     * )
     */
    public function updateProfile(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'nombre' => 'sometimes|string|max:255',
                'telefono' => 'sometimes|string|max:25',
                'imagen_path' => 'sometimes|string|max:255'
            ]);

            $command = new UpdateProfileCommand(
                auth('api')->id(),
                $request->input('nombre'),
                $request->input('telefono'),
                $request->input('imagen_path')
            );

            $profileData = $this->updateProfileHandler->handle($command);

            return response()->json([
                'message' => 'Perfil actualizado exitosamente',
                'data' => $profileData->toArray()
            ]);
        } catch (UsuarioNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error al actualizar perfil: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error al actualizar el perfil'
            ], 500);
        }
    }

    /**
     * @OA\Post(
     * path="/api/Client_usuarios/profile/change-password",
     * tags={"Usuario"},
     * summary="Cambiar contraseña del usuario",
     * description="Permite al usuario cambiar su contraseña actual.",
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(
     * required=true,
     * description="Datos para cambiar contraseña",
     * @OA\JsonContent(
     * required={"current_password", "new_password", "new_password_confirmation"},
     * @OA\Property(property="current_password", type="string", format="password", example="password123"),
     * @OA\Property(property="new_password", type="string", format="password", example="newpassword123"),
     * @OA\Property(property="new_password_confirmation", type="string", format="password", example="newpassword123")
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Contraseña cambiada exitosamente",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Contraseña cambiada exitosamente")
     * )
     * ),
     * @OA\Response(
     * response=422,
     * description="Error de validación"
     * ),
     * @OA\Response(
     * response=401,
     * description="No autenticado o contraseña actual incorrecta"
     * )
     * )
     */
    public function changePassword(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'current_password' => 'required|string',
                'new_password' => 'required|string|min:8|confirmed'
            ]);

            $command = new ChangePasswordCommand(
                auth('api')->id(),
                $request->input('current_password'),
                $request->input('new_password')
            );

            $this->changePasswordHandler->handle($command);

            return response()->json([
                'message' => 'Contraseña cambiada exitosamente'
            ]);
        } catch (UsuarioNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 404);
        } catch (InvalidCredentialsException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 401);
        } catch (\Exception $e) {
            Log::error('Error al cambiar contraseña: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error al cambiar la contraseña'
            ], 500);
        }
    }
}
