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
use Src\Client\usuarios\infrastructure\Persistence\Eloquent\UsuarioModel;

final class LoginUsuarioHandler
{
    public function __construct(
        private UsuarioRepositoryInterface $repository,
        private PasswordHasherInterface $passwordHasher,
        private UsuarioModel $eloquentUserModel
    ) {}

    public function handle(LoginUsuarioCommand $command): AuthTokenData
    {
        try {
            $email = new EmailUsuario($command->email());
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

            $userIdValue = $usuarioDomainEntity->id()->value();
            $userEloquentInstance = $this->eloquentUserModel->find($userIdValue);

            if (!$userEloquentInstance) {
                throw new UsuarioNotFoundException('Modelo de usuario Eloquent no encontrado para la autenticación.');
            }

            $token = auth('api')->login($userEloquentInstance);

            if (!$token) {
                throw new InvalidCredentialsException('No se pudo generar el token de autenticación.');
            }

            $expiresInSeconds = auth('api')->factory()->getTTL() * 60;

            return new AuthTokenData(
                $token,
                'bearer',
                $expiresInSeconds
            );
        } catch (UsuarioNotFoundException | InvalidCredentialsException $e) {
            throw $e;
        } catch (\Throwable $e) {
            \Log::error('Error en LoginUsuarioHandler: ' . $e->getMessage() . ' Stacktrace: ' . $e->getTraceAsString());
            throw $e;
        }
    }
}