<?php

namespace Src\Admin\especialidades\infrastructure\Persistence;

use Src\Admin\especialidades\domain\Repositories\EspecialidadRepositoryInterface;
use Src\Admin\especialidades\domain\Entities\Especialidad as EspecialidadEntity;
use Src\Admin\especialidades\infrastructure\Models\Especialidad as EspecialidadModel;

class EloquentEspecialidadRepository implements EspecialidadRepositoryInterface
{
    public function findAll(): array
    {
        return EspecialidadModel::all()->map(function ($model) {
            return new EspecialidadEntity(
                $model->id,
                $model->nombre,
                $model->descripcion,
                $model->icono_clave,
                $model->activo
            );
        })->toArray();
    }

    public function findById(int $id): ?EspecialidadEntity
    {
        $model = EspecialidadModel::find($id);
        if (!$model) {
            return null;
        }
        return new EspecialidadEntity(
            $model->id,
            $model->nombre,
            $model->descripcion,
            $model->icono_clave,
            $model->activo
        );
    }

    public function save(EspecialidadEntity $especialidad): void
    {
        EspecialidadModel::create([
            'nombre' => $especialidad->nombre,
            'descripcion' => $especialidad->descripcion,
            'icono_clave' => $especialidad->icono_clave,
            'activo' => $especialidad->activo,
        ]);
    }

    public function update(int $id, EspecialidadEntity $especialidad): void
    {
        $model = EspecialidadModel::findOrFail($id);
        $model->update([
            'nombre' => $especialidad->nombre,
            'descripcion' => $especialidad->descripcion,
            'icono_clave' => $especialidad->icono_clave,
            'activo' => $especialidad->activo,
        ]);
    }

    public function delete(int $id): void
    {
        EspecialidadModel::findOrFail($id)->delete();
    }
}
