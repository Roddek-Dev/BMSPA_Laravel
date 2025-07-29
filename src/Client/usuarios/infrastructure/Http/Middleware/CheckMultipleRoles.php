<?php

declare(strict_types=1);

namespace Src\Client\usuarios\infrastructure\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CheckMultipleRoles
{
    public function handle(Request $request, Closure $next, string $roles)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'No autenticado'
            ], 401);
        }

        $allowedRoles = explode(',', $roles);

        if (!in_array($user->rol, $allowedRoles)) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para acceder a este recurso'
            ], 403);
        }

        return $next($request);
    }
}
