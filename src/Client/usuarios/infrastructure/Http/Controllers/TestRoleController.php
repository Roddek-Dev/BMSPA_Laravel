<?php

declare(strict_types=1);

namespace Src\Client\usuarios\infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;

class TestRoleController
{
    public function testCliente(): JsonResponse
    {
        return response()->json([
            'message' => 'Acceso permitido para clientes',
            'user' => auth()->user()
        ]);
    }

    public function testEmpleado(): JsonResponse
    {
        return response()->json([
            'message' => 'Acceso permitido para empleados',
            'user' => auth()->user()
        ]);
    }

    public function testAdmin(): JsonResponse
    {
        return response()->json([
            'message' => 'Acceso permitido para administradores',
            'user' => auth()->user()
        ]);
    }
} 