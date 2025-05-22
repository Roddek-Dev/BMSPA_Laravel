<?php

declare(strict_types=1);

namespace App\Client\usuarios\application\Auth\Handler;

use App\Client\usuarios\application\Auth\Command\LoginUsuarioCommand;
use App\Client\usuarios\application\Auth\DTO\AuthTokenData;
use App\Client\usuarios\domain\Repositories\UsuarioRepositoryInterface;
use App\Client\usuarios\domain\Services\PasswordHasherInterface;
use App\Client\usuarios\domain\ValueObjects\EmailUsuario;
use App\Client\usuarios\domain\Exception\UsuarioNotFoundException;
use App\Client\usuarios\domain\Exception\InvalidCredentialsException;

final class LoginUsuarioHandler
{
    public function __construct(
        private UsuarioRepositoryInterface $repository,
        private PasswordHasherInterface $passwordHasher
    ) {}

    public function handle(LoginUsuarioCommand $command): AuthTokenData
    {
        $email = new EmailUsuario($command->email());
        $usuario = $this->repository->findByEmail($email);

        if (!$usuario) {
            throw new UsuarioNotFoundException('Usuario no encontrado');
        }

        if (!$usuario->activo()) {
            throw new InvalidCredentialsException('La cuenta está desactivada');
        }

        if (!$this->passwordHasher->verify($command->password(), $usuario->password()->value())) {
            throw new InvalidCredentialsException('Credenciales inválidas');
        }

        // Aquí podrías generar un token JWT o usar el sistema de autenticación de Laravel
        $token = auth()->login($usuario);

        return new AuthTokenData(
            $token,
            'bearer',
            config('jwt.ttl') * 60 // Tiempo de expiración en segundos
        );
    }
} 