<?php

declare(strict_types=1);

namespace Src\Client\usuarios\application\Auth\Handler;

use Src\Client\usuarios\application\Auth\Command\LoginUsuarioCommand;
use Src\Client\usuarios\application\Auth\DTO\AuthTokenData;
use Src\Client\usuarios\domain\Repositories\UsuarioRepositoryInterface;
use Src\Client\usuarios\domain\Services\PasswordHasherInterface;
use Src\Client\usuarios\domain\ValueObjects\EmailUsuario;
use Src\Client\usuarios\domain\Exception\UsuarioNotFoundException;
use Src\Client\usuarios\domain\Exception\InvalidCredentialsException;
use Src\Client\usuarios\infrastructure\Persistence\Eloquent\UsuarioModel; // 1. Importar el UsuarioModel

final class LoginUsuarioHandler
{
    public function __construct(
        private UsuarioRepositoryInterface $repository,
        private PasswordHasherInterface $passwordHasher,
        private UsuarioModel $eloquentUserModel // 2. Inyectar el UsuarioModel
    ) {}

    public function handle(LoginUsuarioCommand $command): AuthTokenData
    {
        $email = new EmailUsuario($command->email());
        // $usuario es tu Entidad de Dominio
        $usuarioDomainEntity = $this->repository->findByEmail($email);

        if (!$usuarioDomainEntity) {
            throw new UsuarioNotFoundException('Usuario no encontrado');
        }

        if (!$usuarioDomainEntity->activo()) {
            throw new InvalidCredentialsException('La cuenta está desactivada');
        }

        if (!$this->passwordHasher->verify($command->password(), $usuarioDomainEntity->password()->value())) {
            throw new InvalidCredentialsException('Credenciales inválidas');
        }

        // 3. Obtener la instancia del modelo Eloquent usando el ID de la entidad de dominio
        $userEloquentInstance = $this->eloquentUserModel->find($usuarioDomainEntity->id()->value());

        if (!$userEloquentInstance) {
            // Esto sería muy improbable si $usuarioDomainEntity existe y los IDs coinciden,
            // pero es una comprobación de seguridad.
            throw new UsuarioNotFoundException('Modelo de usuario Eloquent no encontrado para la autenticación.');
        }

        // 4. Generar el token usando la instancia del modelo Eloquent
        // El guard 'api' es común para JWT con tymon/jwt-auth.
        // Si tu guard por defecto es 'api', auth()->login() sería suficiente.
        $token = auth('api')->login($userEloquentInstance);

        if (!$token) {
            // Esto podría suceder si hay un problema con la configuración de JWT o el modelo.
            throw new InvalidCredentialsException('No se pudo generar el token de autenticación.');
        }

        // 5. Obtener el TTL de la configuración de JWT (ej. tymon/jwt-auth)
        // auth()->factory()->getTTL() devuelve el TTL en minutos.
        $expiresInSeconds = auth()->factory()->getTTL() * 60;

        return new AuthTokenData(
            $token,
            'bearer',
            $expiresInSeconds
        );
    }
}