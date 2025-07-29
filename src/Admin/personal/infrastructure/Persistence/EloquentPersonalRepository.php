<?php

namespace Src\Admin\personal\infrastructure\Persistence;

use Src\Admin\personal\domain\Repositories\PersonalRepository;
use Src\Admin\personal\domain\Entities\Personal;
use Src\Admin\personal\infrastructure\Models\PersonalModel;
use Src\Client\usuarios\infrastructure\Persistence\Eloquent\UsuarioModel;
use Illuminate\Support\Facades\DB;

class EloquentPersonalRepository implements PersonalRepository
{
    public function findById(int $id): ?Personal
    {
        $model = PersonalModel::find($id);
        if (!$model) {
            return null;
        }
        return $this->toEntity($model);
    }

    public function findAll(): array
    {
        return PersonalModel::all()->map(fn($model) => $this->toEntity($model))->toArray();
    }

    public function save(Personal $personal): void
    {
        PersonalModel::create($this->toArray($personal));
    }

    public function update(int $id, Personal $personal): void
    {
        $model = PersonalModel::findOrFail($id);
        $model->update($this->toArray($personal));
    }

    public function delete(int $id): void
    {
        PersonalModel::findOrFail($id)->delete();
    }

    public function promoverClienteAEmpleado(int $usuarioId, int $sucursalAsignadaId): void
    {
        DB::transaction(function () use ($usuarioId, $sucursalAsignadaId) {
            // Verificar que el usuario existe y es CLIENTE
            $usuario = UsuarioModel::find($usuarioId);
            if (!$usuario) {
                throw new \Exception('Usuario no encontrado');
            }

            if ($usuario->rol !== 'CLIENTE') {
                throw new \Exception('El usuario no es un cliente');
            }

            // Verificar que no ya existe un registro de personal para este usuario
            if ($this->usuarioTienePersonal($usuarioId)) {
                throw new \Exception('El usuario ya es empleado');
            }

            // Actualizar el rol del usuario a EMPLEADO
            $usuario->rol = 'EMPLEADO';
            $usuario->save();

            // Crear el registro de personal
            PersonalModel::create([
                'usuario_id' => $usuarioId,
                'sucursal_asignada_id' => $sucursalAsignadaId,
                'tipo_personal' => 'EMPLEADO',
                'numero_empleado' => 'EMP-' . str_pad($usuarioId, 3, '0', STR_PAD_LEFT),
                'fecha_contratacion' => now()->format('Y-m-d'),
                'activo_en_empresa' => true,
            ]);
        });
    }

    public function promoverEmpleadoAAdmin(int $personalId): void
    {
        DB::transaction(function () use ($personalId) {
            // Buscar el registro de personal
            $personal = PersonalModel::find($personalId);
            if (!$personal) {
                throw new \Exception('Personal no encontrado');
            }

            // Obtener el usuario asociado
            $usuario = UsuarioModel::find($personal->usuario_id);
            if (!$usuario) {
                throw new \Exception('Usuario asociado no encontrado');
            }

            // Verificar que el usuario es EMPLEADO
            if ($usuario->rol !== 'EMPLEADO') {
                throw new \Exception('El usuario no es empleado');
            }

            // Actualizar el rol del usuario a ADMIN_SUCURSAL
            $usuario->rol = 'ADMIN_SUCURSAL';
            $usuario->save();

            // Actualizar el tipo de personal
            $personal->tipo_personal = 'ADMIN_SUCURSAL';
            $personal->save();
        });
    }

    public function usuarioTienePersonal(int $usuarioId): bool
    {
        return PersonalModel::where('usuario_id', $usuarioId)->exists();
    }

    private function toEntity(PersonalModel $model): Personal
    {
        return new Personal(
            $model->id,
            $model->usuario_id,
            $model->sucursal_asignada_id,
            $model->tipo_personal,
            $model->numero_empleado,
            $model->fecha_contratacion ? $model->fecha_contratacion->format('Y-m-d') : null,
            $model->activo_en_empresa
        );
    }

    private function toArray(Personal $personal): array
    {
        return [
            'usuario_id' => $personal->usuario_id,
            'sucursal_asignada_id' => $personal->sucursal_asignada_id,
            'tipo_personal' => $personal->tipo_personal,
            'numero_empleado' => $personal->numero_empleado,
            'fecha_contratacion' => $personal->fecha_contratacion,
            'activo_en_empresa' => $personal->activo_en_empresa,
        ];
    }
}
