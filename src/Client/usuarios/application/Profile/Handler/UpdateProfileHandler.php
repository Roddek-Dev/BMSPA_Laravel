<?php

declare(strict_types=1);

namespace Src\Client\usuarios\application\Profile\Handler;

use Illuminate\Support\Facades\Log;
use Src\Client\usuarios\application\Profile\Command\UpdateProfileCommand;
use Src\Client\usuarios\application\Profile\DTO\ProfileData;
use Src\Client\usuarios\domain\Repositories\UsuarioRepositoryInterface;
use Src\Client\usuarios\domain\ValueObjects\UsuarioId;
use Src\Client\usuarios\domain\ValueObjects\NombreUsuario;
use Src\Client\usuarios\domain\ValueObjects\EmailUsuario;
use Src\Client\usuarios\domain\ValueObjects\PasswordHashed;
use Src\Client\usuarios\domain\Entities\Usuario;
use Src\Client\usuarios\domain\Exception\UsuarioNotFoundException;

final class UpdateProfileHandler
{
    public function __construct(
        private UsuarioRepositoryInterface $repository
    ) {}

    public function handle(UpdateProfileCommand $command): ProfileData
    {
        $usuarioId = new UsuarioId($command->userId());
        $usuario = $this->repository->findById($usuarioId);

        if (!$usuario) {
            throw new UsuarioNotFoundException('Usuario no encontrado');
        }

        // CORRECTO: Llama al método de la entidad para actualizar su estado
        $usuario->actualizarPerfil(
            $command->nombre(),
            $command->telefono(),
            $command->imagenPath()
        );

        // Guarda la entidad que acabas de modificar
        $savedUsuario = $this->repository->save($usuario);

        return new ProfileData(
            $savedUsuario->id()->value(),
            $savedUsuario->nombre()->value(),
            $savedUsuario->email()->value(),
            $savedUsuario->telefono(),
            $savedUsuario->rol(),
            $savedUsuario->activo(),
            $savedUsuario->imagenPath(),
            date('Y-m-d H:i:s'),
            date('Y-m-d H:i:s')
        );
    }
}
