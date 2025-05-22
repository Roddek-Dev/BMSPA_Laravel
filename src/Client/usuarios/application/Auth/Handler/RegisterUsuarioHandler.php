<?php

declare(strict_types=1);

namespace Src\Client\usuarios\application\Auth\Handler;

use Src\Client\usuarios\application\Auth\Command\RegisterUsuarioCommand;
use Src\Client\usuarios\application\Auth\DTO\RegisteredUsuarioData;
use Src\Client\usuarios\domain\Entities\Usuario;
use Src\Client\usuarios\domain\Repositories\UsuarioRepositoryInterface;
use Src\Client\usuarios\domain\Services\PasswordHasherInterface;
use Src\Client\usuarios\domain\ValueObjects\EmailUsuario;
use Src\Client\usuarios\domain\ValueObjects\NombreUsuario;
use Src\Client\usuarios\domain\ValueObjects\PasswordHashed;
use Src\Client\usuarios\domain\ValueObjects\UsuarioId;

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

        // La entidad Usuario ya recibe la contraseña hasheada
        $hashedPassword = $this->passwordHasher->hash($command->password());

        $usuario = new Usuario(
            new UsuarioId(0), // El ID será asignado por la BD, y actualizado por el repo
            new NombreUsuario($command->nombre()),
            $email,
            new PasswordHashed($hashedPassword), // Pasar el password ya hasheado
            $command->telefono()
            // Los demás campos tomarán sus valores por defecto del constructor de Usuario
        );

        // $this->repository->save($usuario); // Antes
        $persistedUsuario = $this->repository->save($usuario); // DESPUÉS: Capturar la entidad devuelta

        return new RegisteredUsuarioData(
            $persistedUsuario->id()->value(), // Ahora tendrá el ID correcto de la BD
            $persistedUsuario->nombre()->value(),
            $persistedUsuario->email()->value()
        );
    }
} 