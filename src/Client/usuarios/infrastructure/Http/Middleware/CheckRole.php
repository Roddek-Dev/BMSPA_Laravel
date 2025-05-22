<?php

declare(strict_types=1);

namespace Src\Client\usuarios\infrastructure\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!$request->user() || $request->user()->rol !== $role) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para acceder a este recurso'
            ], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
} 