<?php

declare(strict_types=1);

namespace Src\Client\usuarios\infrastructure\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class CheckMultipleRoles
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'No autenticado'
            ], 401);
        }

        // Debug: Log para verificar los valores
        Log::info('CheckMultipleRoles Debug - Inicio', [
            'roles_parameters' => $roles,
            'roles_count' => count($roles)
        ]);

        $allowedRoles = $roles;

        // Debug: Log para verificar los valores
        Log::info('CheckMultipleRoles Debug', [
            'user_id' => $user->id,
            'user_rol' => $user->rol,
            'allowed_roles' => $allowedRoles,
            'in_array_result' => in_array($user->rol, $allowedRoles)
        ]);

        if (!in_array($user->rol, $allowedRoles)) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para acceder a este recurso. Rol actual: ' . $user->rol . ', Roles permitidos: ' . implode(', ', $allowedRoles)
            ], 403);
        }

        return $next($request);
    }
}
