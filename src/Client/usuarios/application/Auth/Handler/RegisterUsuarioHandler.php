<?php

declare(strict_types=1);

namespace App\Client\usuarios\application\Auth\Handler;

use App\Client\usuarios\application\Auth\Command\RegisterUsuarioCommand;
use App\Client\usuarios\application\Auth\DTO\RegisteredUsuarioData;
use App\Client\usuarios\domain\Entities\Usuario;
use App\Client\usuarios\domain\Repositories\UsuarioRepositoryInterface;
use App\Client\usuarios\domain\Services\PasswordHasherInterface;
use App\Client\usuarios\domain\ValueObjects\EmailUsuario;
use App\Client\usuarios\domain\ValueObjects\NombreUsuario;
use App\Client\usuarios\domain\ValueObjects\PasswordHashed;
use App\Client\usuarios\domain\ValueObjects\UsuarioId;

final class RegisterUsuarioHandler
{
    public function __construct(
        private UsuarioRepositoryInterface $repository,
        private PasswordHasherInterface $passwordHasher
    ) {}

    public function handle(RegisterUsuarioCommand $command): RegisteredUsuarioData
    {
        $email = new EmailUsuario($command->email());
        
        if ($this->repository->exists($email)) {
            throw new \DomainException('El email ya está registrado');
        }

        $usuario = new Usuario(
            new UsuarioId(0), // El ID será asignado por la base de datos
            new NombreUsuario($command->nombre()),
            $email,
            new PasswordHashed($this->passwordHasher->hash($command->password())),
            $command->telefono()
        );

        $this->repository->save($usuario);

        return new RegisteredUsuarioData(
            $usuario->id()->value(),
            $usuario->nombre()->value(),
            $usuario->email()->value()
        );
    }
} 