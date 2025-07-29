<?php

declare(strict_types=1);

namespace Src\Client\usuarios\infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Src\Client\usuarios\application\Auth\Command\LoginUsuarioCommand;
use Src\Client\usuarios\application\Auth\Command\RegisterUsuarioCommand;
use Src\Client\usuarios\application\Auth\Handler\LoginUsuarioHandler;
use Src\Client\usuarios\application\Auth\Handler\RegisterUsuarioHandler;
use Src\Client\usuarios\domain\Exception\InvalidCredentialsException;
use Src\Client\usuarios\domain\Exception\UsuarioNotFoundException;
use Src\Client\usuarios\infrastructure\Http\Requests\LoginRequest;
use Src\Client\usuarios\infrastructure\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function __construct(
        private RegisterUsuarioHandler $registerHandler,
        private LoginUsuarioHandler $loginHandler
    ) {}

    /**
     * @OA\Post(
     * path="/api/Client_usuarios/auth/register",
     * tags={"Autenticación"},
     * summary="Registrar un nuevo usuario",
     * description="Crea una nueva cuenta de usuario en el sistema con rol CLIENTE por defecto.",
     * @OA\RequestBody(
     * required=true,
     * description="Datos del usuario para el registro",
     * @OA\JsonContent(
     * required={"nombre", "email", "password", "password_confirmation"},
     * @OA\Property(property="nombre", type="string", example="Juan Pérez", description="Nombre completo del usuario"),
     * @OA\Property(property="email", type="string", format="email", example="juan.perez@example.com", description="Email único del usuario"),
     * @OA\Property(property="password", type="string", format="password", example="password123", description="Contraseña mínima 8 caracteres"),
     * @OA\Property(property="password_confirmation", type="string", format="password", example="password123", description="Confirmación de contraseña"),
     * @OA\Property(property="telefono", type="string", example="3101234567", description="Teléfono único del usuario")
     * )
     * ),
     * @OA\Response(
     * response=201,
     * description="Usuario registrado exitosamente",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Usuario registrado exitosamente"),
     * @OA\Property(property="data", type="object",
     * @OA\Property(property="id", type="integer", example=1),
     * @OA\Property(property="nombre", type="string", example="Juan Pérez"),
     * @OA\Property(property="email", type="string", format="email", example="juan.perez@example.com"),
     * @OA\Property(property="rol", type="string", example="CLIENTE"),
     * @OA\Property(property="activo", type="boolean", example=true)
     * )
     * )
     * ),
     * @OA\Response(
     * response=422,
     * description="Error de validación",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Los datos proporcionados no son válidos"),
     * @OA\Property(property="errors", type="object")
     * )
     * ),
     * @OA\Response(
     * response=409,
     * description="Email o teléfono ya existe",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="El email ya está registrado")
     * )
     * )
     * )
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $command = new RegisterUsuarioCommand(
                $request->input('nombre'),
                $request->input('email'),
                $request->input('password'),
                $request->input('telefono')
            );

            $registeredUsuarioData = $this->registerHandler->handle($command);

            return response()->json([
                'message' => 'Usuario registrado exitosamente',
                'data' => $registeredUsuarioData->toArray()
            ], 201);
        } catch (\DomainException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 409);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        } catch (\Exception $e) {
            Log::error('Error en el registro: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error interno del servidor'
            ], 500);
        }
    }

    /**
     * @OA\Post(
     * path="/api/Client_usuarios/auth/login",
     * tags={"Autenticación"},
     * summary="Iniciar sesión",
     * description="Autentica a un usuario y devuelve un token JWT de acceso.",
     * @OA\RequestBody(
     * required=true,
     * description="Credenciales del usuario",
     * @OA\JsonContent(
     * required={"email", "password"},
     * @OA\Property(property="email", type="string", format="email", example="juan.perez@example.com", description="Email del usuario"),
     * @OA\Property(property="password", type="string", format="password", example="password123", description="Contraseña del usuario")
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Login exitoso",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Login exitoso"),
     * @OA\Property(property="data", type="object",
     * @OA\Property(property="token", type="string", example="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...", description="Token JWT para autenticación"),
     * @OA\Property(property="type", type="string", example="bearer", description="Tipo de token"),
     * @OA\Property(property="expires_in", type="integer", example=3600, description="Tiempo de expiración en segundos")
     * )
     * )
     * ),
     * @OA\Response(
     * response=401,
     * description="Credenciales inválidas",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Credenciales inválidas")
     * )
     * ),
     * @OA\Response(
     * response=422,
     * description="Error de validación",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Los datos proporcionados no son válidos"),
     * @OA\Property(property="errors", type="object")
     * )
     * )
     * )
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $command = new LoginUsuarioCommand(
                $request->input('email'),
                $request->input('password')
            );
            $result = $this->loginHandler->handle($command);
            return response()->json([
                'message' => 'Login exitoso',
                'data' => $result->toArray()
            ]);
        } catch (UsuarioNotFoundException | InvalidCredentialsException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al iniciar sesión'
            ], 500);
        }
    }

    /**
     * @OA\Post(
     * path="/api/Client_usuarios/auth/logout",
     * tags={"Autenticación"},
     * summary="Cerrar sesión",
     * description="Invalida el token JWT del usuario actual y cierra la sesión.",
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     * response=200,
     * description="Sesión cerrada exitosamente",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Sesión cerrada exitosamente")
     * )
     * ),
     * @OA\Response(
     * response=401,
     * description="No autenticado",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Unauthenticated")
     * )
     * ),
     * @OA\Response(
     * response=500,
     * description="Error interno del servidor",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Error al cerrar sesión")
     * )
     * )
     * )
     */
    public function logout(): JsonResponse
    {
        try {
            // Con JWT, invalidamos el token actual usando el guard 'api'
            auth('api')->logout();

            return response()->json([
                'message' => 'Sesión cerrada exitosamente'
            ]);
        } catch (\Exception $e) {
            Log::error('Error al cerrar sesión: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error al cerrar sesión'
            ], 500);
        }
    }
}
