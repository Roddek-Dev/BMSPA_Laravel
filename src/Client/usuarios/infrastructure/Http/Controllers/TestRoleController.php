<?php

declare(strict_types=1);

namespace Src\Client\usuarios\infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller; // <-- Asegúrate de que herede de Controller

class TestRoleController extends Controller // <-- Y que la clase lo extienda
{
    /**
     * @OA\Get(
     * path="/api/Client_usuarios/auth/test-cliente",
     * tags={"Roles de Prueba"},
     * summary="Probar acceso con rol de Cliente",
     * description="Endpoint para verificar si el usuario autenticado tiene acceso como cliente.",
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     * response=200,
     * description="Acceso permitido.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Acceso permitido para clientes"),
     * @OA\Property(property="user", type="object")
     * )
     * ),
     * @OA\Response(
     * response=401,
     * description="No autenticado."
     * ),
     * @OA\Response(
     * response=403,
     * description="Acceso denegado (Forbidden)."
     * )
     * )
     */
    public function testCliente(): JsonResponse
    {
        return response()->json([
            'message' => 'Acceso permitido para clientes',
            'user' => auth()->user()
        ]);
    }

    /**
     * @OA\Get(
     * path="/api/Client_usuarios/auth/test-empleado",
     * tags={"Roles de Prueba"},
     * summary="Probar acceso con rol de Empleado",
     * description="Endpoint para verificar si el usuario autenticado tiene acceso como empleado.",
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     * response=200,
     * description="Acceso permitido.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Acceso permitido para empleados"),
     * @OA\Property(property="user", type="object")
     * )
     * ),
     * @OA\Response(
     * response=401,
     * description="No autenticado."
     * ),
     * @OA\Response(
     * response=403,
     * description="Acceso denegado (Forbidden)."
     * )
     * )
     */
    public function testEmpleado(): JsonResponse
    {
        return response()->json([
            'message' => 'Acceso permitido para empleados',
            'user' => auth()->user()
        ]);
    }

    /**
     * @OA\Get(
     * path="/api/Client_usuarios/auth/test-admin-sucursal",
     * tags={"Roles de Prueba"},
     * summary="Probar acceso con rol de Administrador de Sucursal",
     * description="Endpoint para verificar si el usuario autenticado tiene acceso como administrador de sucursal.",
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     * response=200,
     * description="Acceso permitido.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Acceso permitido para administradores de sucursal"),
     * @OA\Property(property="user", type="object")
     * )
     * ),
     * @OA\Response(
     * response=401,
     * description="No autenticado."
     * ),
     * @OA\Response(
     * response=403,
     * description="Acceso denegado (Forbidden)."
     * )
     * )
     */
    public function testAdminSucursal(): JsonResponse
    {
        return response()->json([
            'message' => 'Acceso permitido para administradores de sucursal',
            'user' => auth()->user()
        ]);
    }

    /**
     * @OA\Get(
     * path="/api/Client_usuarios/auth/test-gerente",
     * tags={"Roles de Prueba"},
     * summary="Probar acceso con rol de Gerente",
     * description="Endpoint para verificar si el usuario autenticado tiene acceso como gerente.",
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     * response=200,
     * description="Acceso permitido.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Acceso permitido para gerentes"),
     * @OA\Property(property="user", type="object")
     * )
     * ),
     * @OA\Response(
     * response=401,
     * description="No autenticado."
     * ),
     * @OA\Response(
     * response=403,
     * description="Acceso denegado (Forbidden)."
     * )
     * )
     */
    public function testGerente(): JsonResponse
    {
        return response()->json([
            'message' => 'Acceso permitido para gerentes',
            'user' => auth()->user()
        ]);
    }
}