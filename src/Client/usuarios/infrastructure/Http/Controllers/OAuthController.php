<?php

declare(strict_types=1);

namespace Src\Client\usuarios\infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Client;
use Laravel\Passport\Passport;

class OAuthController
{
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Credenciales inválidas'
            ], 401);
        }

        $user = Auth::user();
        
        if (!$user->activo) {
            return response()->json([
                'message' => 'Cuenta desactivada'
            ], 403);
        }

        // Crear o recuperar el cliente OAuth
        $client = Client::where('password_client', 1)->first();
        
        if (!$client) {
            $client = Passport::client()->forceFill([
                'user_id' => null,
                'name' => 'Password Grant Client',
                'secret' => \Str::random(40),
                'provider' => 'usuarios',
                'redirect' => 'http://localhost',
                'personal_access_client' => false,
                'password_client' => true,
                'revoked' => false,
            ]);
            $client->save();
        }

        // Solicitar token OAuth
        $tokenRequest = Request::create('/oauth/token', 'POST', [
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => $request->email,
            'password' => $request->password,
            'scope' => '',
        ]);

        $response = app()->handle($tokenRequest);
        $tokenData = json_decode($response->getContent(), true);

        if ($response->getStatusCode() !== 200) {
            return response()->json([
                'message' => 'Error al generar el token'
            ], 500);
        }

        return response()->json([
            'access_token' => $tokenData['access_token'],
            'refresh_token' => $tokenData['refresh_token'],
            'token_type' => 'Bearer',
            'expires_in' => $tokenData['expires_in'],
            'user' => $user
        ]);
    }

    public function refresh(Request $request): JsonResponse
    {
        $request->validate([
            'refresh_token' => 'required|string'
        ]);

        $client = Client::where('password_client', 1)->first();

        $tokenRequest = Request::create('/oauth/token', 'POST', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $request->refresh_token,
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'scope' => '',
        ]);

        $response = app()->handle($tokenRequest);
        $tokenData = json_decode($response->getContent(), true);

        if ($response->getStatusCode() !== 200) {
            return response()->json([
                'message' => 'Error al refrescar el token'
            ], 500);
        }

        return response()->json([
            'access_token' => $tokenData['access_token'],
            'refresh_token' => $tokenData['refresh_token'],
            'token_type' => 'Bearer',
            'expires_in' => $tokenData['expires_in']
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->token()->revoke();
        
        return response()->json([
            'message' => 'Sesión cerrada exitosamente'
        ]);
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'user' => $request->user()
        ]);
    }
} 