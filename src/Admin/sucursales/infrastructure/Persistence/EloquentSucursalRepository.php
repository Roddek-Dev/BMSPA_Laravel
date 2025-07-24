<?php

namespace Src\Admin\sucursales\infrastructure\Persistence;

use Src\Admin\sucursales\domain\Repositories\SucursalRepository;
use Src\Admin\sucursales\domain\Entities\Sucursal;
use Src\Admin\sucursales\infrastructure\Models\SucursalModel;

class EloquentSucursalRepository implements SucursalRepository
{
    public function create(Sucursal $sucursal): Sucursal
    {
        $model = SucursalModel::create([
            'nombre' => $sucursal->nombre,
            'imagen_path' => $sucursal->imagen_path,
            'telefono_contacto' => $sucursal->telefono_contacto,
            'email_contacto' => $sucursal->email_contacto,
            'link_maps' => $sucursal->link_maps,
            'latitud' => $sucursal->latitud,
            'longitud' => $sucursal->longitud,
            'activo' => $sucursal->activo,
        ]);

        return new Sucursal(
            $model->id,
            $model->nombre,
            $model->imagen_path,
            $model->telefono_contacto,
            $model->email_contacto,
            $model->link_maps,
            $model->latitud,
            $model->longitud,
            $model->activo
        );
    }

    public function findAll(): array
    {
        return SucursalModel::all()->map(function ($model) {
            return new Sucursal(
                $model->id,
                $model->nombre,
                $model->imagen_path,
                $model->telefono_contacto,
                $model->email_contacto,
                $model->link_maps,
                $model->latitud,
                $model->longitud,
                $model->activo
            );
        })->toArray();
    }

    public function find(int $id): ?Sucursal
    {
        $model = SucursalModel::find($id);
        if (!$model) {
            return null;
        }
        return new Sucursal(
            $model->id,
            $model->nombre,
            $model->imagen_path,
            $model->telefono_contacto,
            $model->email_contacto,
            $model->link_maps,
            $model->latitud,
            $model->longitud,
            $model->activo
        );
    }

    public function update(int $id, Sucursal $sucursal): Sucursal
    {
        $model = SucursalModel::findOrFail($id);
        $model->update([
            'nombre' => $sucursal->nombre,
            'imagen_path' => $sucursal->imagen_path,
            'telefono_contacto' => $sucursal->telefono_contacto,
            'email_contacto' => $sucursal->email_contacto,
            'link_maps' => $sucursal->link_maps,
            'latitud' => $sucursal->latitud,
            'longitud' => $sucursal->longitud,
            'activo' => $sucursal->activo,
        ]);

        return new Sucursal(
            $model->id,
            $model->nombre,
            $model->imagen_path,
            $model->telefono_contacto,
            $model->email_contacto,
            $model->link_maps,
            $model->latitud,
            $model->longitud,
            $model->activo
        );
    }

    public function delete(int $id): void
    {
        SucursalModel::findOrFail($id)->delete();
    }
}
