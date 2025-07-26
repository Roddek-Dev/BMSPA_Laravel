<?php

namespace Src\Catalog\servicios\infrastructure\Persistence;

use Src\Catalog\servicios\domain\Repositories\ServicioRepository;
use Src\Catalog\servicios\domain\Entities\Servicio;
use Src\Catalog\servicios\infrastructure\Models\ServicioModel;

class EloquentServicioRepository implements ServicioRepository
{
    public function findById(int $id): ?Servicio
    {
        $model = ServicioModel::find($id);
        if (!$model) {
            return null;
        }
        return new Servicio(
            $model->id,
            $model->nombre,
            $model->descripcion,
            $model->imagen_path,
            $model->precio_base,
            $model->duracion_minutos,
            $model->categoria_id,
            $model->especialidad_requerida_id,
            $model->activo
        );
    }

    public function findAll(): array
    {
        return ServicioModel::all()->map(function ($model) {
            return new Servicio(
                $model->id,
                $model->nombre,
                $model->descripcion,
                $model->imagen_path,
                $model->precio_base,
                $model->duracion_minutos,
                $model->categoria_id,
                $model->especialidad_requerida_id,
                $model->activo
            );
        })->toArray();
    }

    public function save(Servicio $servicio): void
    {
        ServicioModel::create([
            'nombre' => $servicio->nombre,
            'descripcion' => $servicio->descripcion,
            'imagen_path' => $servicio->imagen_path,
            'precio_base' => $servicio->precio_base,
            'duracion_minutos' => $servicio->duracion_minutos,
            'categoria_id' => $servicio->categoria_id,
            'especialidad_requerida_id' => $servicio->especialidad_requerida_id,
            'activo' => $servicio->activo,
        ]);
    }

    public function update(int $id, Servicio $servicio): void
    {
        $model = ServicioModel::findOrFail($id);
        $model->update([
            'nombre' => $servicio->nombre,
            'descripcion' => $servicio->descripcion,
            'imagen_path' => $servicio->imagen_path,
            'precio_base' => $servicio->precio_base,
            'duracion_minutos' => $servicio->duracion_minutos,
            'categoria_id' => $servicio->categoria_id,
            'especialidad_requerida_id' => $servicio->especialidad_requerida_id,
            'activo' => $servicio->activo,
        ]);
    }

    public function delete(int $id): void
    {
        ServicioModel::findOrFail($id)->delete();
    }
}