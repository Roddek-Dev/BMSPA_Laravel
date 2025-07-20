<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 * version="1.0.0",
 * title="API de BarberMusic&Spa",
 * description="Documentación para la API utilizada en el sistema de BarberMusic&Spa. Aquí puedes probar los endpoints de autenticación.",
 * @OA\Contact(
 * email="soporte@barbermusic.com"
 * )
 * )
 * 
 * @OA\Server(
 * url="http://localhost:8000",
 * description="Servidor local de desarrollo"
 * )
 * 
 * @OA\SecurityScheme(
 * securityScheme="bearerAuth",
 * type="http",
 * scheme="bearer",
 * bearerFormat="JWT",
 * description="Introduce el token de acceso (JWT o Sanctum) sin la palabra 'Bearer'."
 * )
 * 
 * @OA\PathItem(
 * path="/api/Client_usuarios/auth/register"
 * )
 * 
 * @OA\PathItem(
 * path="/api/Client_usuarios/auth/login"
 * )
 * 
 * @OA\PathItem(
 * path="/api/Client_usuarios/auth/logout"
 * )
 * 
 * @OA\PathItem(
 * path="/api/Client_usuarios/auth/test-admin-sucursal"
 * )
 * 
 * @OA\PathItem(
 * path="/api/Client_usuarios/auth/test-gerente"
 * )
 * 
 * @OA\PathItem(
 * path="/api/Client_usuarios/auth/test-empleado"
 * )
 * 
 * @OA\PathItem(
 * path="/api/Client_usuarios/auth/test-cliente"
 * )
 */
abstract class Controller
{
    //
}
