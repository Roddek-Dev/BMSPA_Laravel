<?php

namespace Src\Admin\categorias\infrastructure\Persistence;

use Src\Admin\categorias\domain\Repositories\CategoriaRepository;
use Src\Admin\categorias\domain\Entities\Categoria;
use Src\Admin\categorias\infrastructure\Models\CategoriaModel;

class EloquentCategoriaRepository implements CategoriaRepository
{
    public function findById(int $id): ?Categoria
    {
        $model = CategoriaModel::find($id);
        if (!$model) {
            return null;
        }
        return new Categoria(
            $model->id,
            $model->nombre,
            $model->descripcion,
            $model->tipo_categoria,
            $model->icono_clave,
            $model->activo
        );
    }

    public function findAll(): array
    {
        return CategoriaModel::all()->map(function ($model) {
            return new Categoria(
                $model->id,
                $model->nombre,
                $model->descripcion,
                $model->tipo_categoria,
                $model->icono_clave,
                $model->activo
            );
        })->toArray();
    }

    public function save(Categoria $categoria): void
    {
        CategoriaModel::create([
            'nombre' => $categoria->nombre,
            'descripcion' => $categoria->descripcion,
            'tipo_categoria' => $categoria->tipo_categoria,
            'icono_clave' => $categoria->icono_clave,
            'activo' => $categoria->activo,
        ]);
    }

    public function update(int $id, Categoria $categoria): void
    {
        $model = CategoriaModel::findOrFail($id);
        $model->update([
            'nombre' => $categoria->nombre,
            'descripcion' => $categoria->descripcion,
            'tipo_categoria' => $categoria->tipo_categoria,
            'icono_clave' => $categoria->icono_clave,
            'activo' => $categoria->activo,
        ]);
    }

    public function delete(int $id): void
    {
        CategoriaModel::findOrFail($id)->delete();
    }
}