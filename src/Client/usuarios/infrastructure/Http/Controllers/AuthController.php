<?php

declare(strict_types=1);

namespace Src\Client\usuarios\infrastructure\Http\Controllers;

use Src\Client\usuarios\application\Auth\Command\RegisterUsuarioCommand;
use Src\Client\usuarios\application\Auth\Command\LoginUsuarioCommand;
use Src\Client\usuarios\application\Auth\Handler\RegisterUsuarioHandler;
use Src\Client\usuarios\application\Auth\Handler\LoginUsuarioHandler;
use Src\Client\usuarios\infrastructure\Http\Requests\RegisterRequest;
use Src\Client\usuarios\infrastructure\Http\Requests\LoginRequest;
use Src\Client\usuarios\domain\Exception\UsuarioNotFoundException;
use Src\Client\usuarios\domain\Exception\InvalidCredentialsException;
use Illuminate\Support\Facades\Log; // Añade esto al principio
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    public function __construct(
        private RegisterUsuarioHandler $registerHandler,
        private LoginUsuarioHandler $loginHandler
    ) {}
    public function register(RegisterRequest $request): JsonResponse
    {
        Log::info('Register endpoint hit.', $request->all()); // Registra los datos de la solicitud
        try {
            $command = new RegisterUsuarioCommand(
                $request->input('nombre'),
                $request->input('email'),
                $request->input('password'),
                $request->input('telefono')
            );
    
            Log::info('RegisterUsuarioCommand created.', (array) $command);
    
            $result = $this->registerHandler->handle($command);
    
            Log::info('User registration successful in handler.', $result->toArray());
    
            return response()->json([
                'message' => 'Usuario registrado exitosamente',
                'data' => $result->toArray()
            ], 201); // El registro exitoso debería ser 201
    
        } catch (\Src\Client\usuarios\domain\Exception\UsuarioAlreadyExistsException $e) { // O tu excepción de dominio específica para usuario existente
            Log::warning('Registration failed: UsuarioAlreadyExistsException - ' . $e->getMessage(), ['email' => $request->input('email')]);
            return response()->json([
                'message' => $e->getMessage()
            ], 409); // 409 Conflict también es común para "ya existe"
        } catch (\DomainException $e) { //
            Log::warning('Registration failed: DomainException - ' . $e->getMessage(), ['exception_trace' => $e->getTraceAsString()]);
            return response()->json([ //
                'message' => $e->getMessage() //
            ], 400); //
        } catch (\Throwable $e) { // Captura Throwable para más cobertura de errores
            Log::error('Critical error during registration: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([ //
                'message' => 'Error al registrar el usuario: ' . $e->getMessage() // Incluye el mensaje de error para depuración
            ], 500); //
        }
    }
    
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

    public function logout(): JsonResponse
    {
        try {
            auth()->logout();
            return response()->json([
                'message' => 'Sesión cerrada exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al cerrar sesión'
            ], 500);
        }
    }
} 