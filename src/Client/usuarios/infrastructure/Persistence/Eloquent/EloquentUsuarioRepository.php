<?php

declare(strict_types=1);

namespace Src\Client\usuarios\infrastructure\Persistence\Eloquent;

use Src\Client\usuarios\domain\Entities\Usuario;
use Src\Client\usuarios\domain\Repositories\UsuarioRepositoryInterface;
use Src\Client\usuarios\domain\ValueObjects\EmailUsuario;
use Src\Client\usuarios\domain\ValueObjects\UsuarioId;
use Src\Client\usuarios\domain\ValueObjects\NombreUsuario;
use Src\Client\usuarios\domain\ValueObjects\PasswordHashed;

class EloquentUsuarioRepository implements UsuarioRepositoryInterface
{
    public function __construct(private UsuarioModel $model) {}

    public function save(Usuario $usuario): Usuario // Implementar el tipo de retorno
    {
        // Tu lógica actual de `create` ya es buena, pero ahora la usamos para crear el modelo
        // y luego lo convertimos de nuevo a la entidad para devolverla.
        // Asumimos que la entidad $usuario ya tiene el password hasheado.
        $model = $this->model->create([
            'nombre' => $usuario->nombre()->value(),
            'email' => $usuario->email()->value(),
            'password' => $usuario->password()->value(), // La entidad debe tenerlo hasheado
            'telefono' => $usuario->telefono(),
            'rol' => $usuario->rol(),
            'activo' => $usuario->activo(),
            'imagen_path' => $usuario->imagenPath(),
            'musica_preferencia_navegacion_id' => $usuario->musicaPreferenciaNavegacionId(),
            'sucursal_preferida_id' => $usuario->sucursalPreferidaId()
        ]);

        // Convertir el modelo Eloquent (que ahora tiene ID) de nuevo a tu entidad de dominio
        return $this->toEntity($model);
    }

    public function findById(UsuarioId $id): ?Usuario
    {
        $model = $this->model->find($id->value());
        
        if (!$model) {
            return null;
        }

        return $this->toEntity($model);
    }

    public function findByEmail(EmailUsuario $email): ?Usuario
    {
        $model = $this->model->where('email', $email->value())->first();
        
        if (!$model) {
            return null;
        }

        return $this->toEntity($model);
    }

    public function delete(UsuarioId $id): void
    {
        $this->model->destroy($id->value());
    }

    public function update(Usuario $usuario): void
    {
        $this->model->where('id', $usuario->id()->value())->update([
            'nombre' => $usuario->nombre()->value(),
            'email' => $usuario->email()->value(),
            'password' => $usuario->password()->value(),
            'telefono' => $usuario->telefono(),
            'rol' => $usuario->rol(),
            'activo' => $usuario->activo(),
            'imagen_path' => $usuario->imagenPath(),
            'musica_preferencia_navegacion_id' => $usuario->musicaPreferenciaNavegacionId(),
            'sucursal_preferida_id' => $usuario->sucursalPreferidaId()
        ]);
    }

    public function exists(EmailUsuario $email): bool
    {
        return $this->model->where('email', $email->value())->exists();
    }

    private function toEntity(UsuarioModel $model): Usuario
    {
        return new Usuario(
            new UsuarioId($model->id),
            new NombreUsuario($model->nombre),
            new EmailUsuario($model->email),
            new PasswordHashed($model->password),
            $model->telefono,
            $model->rol,
            $model->activo,
            $model->imagen_path,
            $model->musica_preferencia_navegacion_id,
            $model->sucursal_preferida_id
        );
    }
} 