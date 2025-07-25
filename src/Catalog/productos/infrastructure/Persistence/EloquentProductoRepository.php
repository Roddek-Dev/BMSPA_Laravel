<?php

namespace Src\Catalog\productos\infrastructure\Persistence;

use Src\Catalog\productos\domain\Repositories\ProductoRepository;
use Src\Catalog\productos\domain\Entities\Producto;
use Src\Catalog\productos\infrastructure\Models\ProductoModel;

class EloquentProductoRepository implements ProductoRepository
{
    public function findById(int $id): ?Producto
    {
        $model = ProductoModel::find($id);
        if (!$model) {
            return null;
        }
        return new Producto(
            $model->id,
            $model->nombre,
            $model->descripcion,
            $model->imagen_path,
            $model->precio,
            $model->stock,
            $model->sku,
            $model->categoria_id,
            $model->activo
        );
    }

    public function findAll(): array
    {
        return ProductoModel::all()->map(function ($model) {
            return new Producto(
                $model->id,
                $model->nombre,
                $model->descripcion,
                $model->imagen_path,
                $model->precio,
                $model->stock,
                $model->sku,
                $model->categoria_id,
                $model->activo
            );
        })->toArray();
    }

    public function save(Producto $producto): void
    {
        ProductoModel::create([
            'nombre' => $producto->nombre,
            'descripcion' => $producto->descripcion,
            'imagen_path' => $producto->imagen_path,
            'precio' => $producto->precio,
            'stock' => $producto->stock,
            'sku' => $producto->sku,
            'categoria_id' => $producto->categoria_id,
            'activo' => $producto->activo,
        ]);
    }

    public function update(int $id, Producto $producto): void
    {
        $model = ProductoModel::findOrFail($id);
        $model->update([
            'nombre' => $producto->nombre,
            'descripcion' => $producto->descripcion,
            'imagen_path' => $producto->imagen_path,
            'precio' => $producto->precio,
            'stock' => $producto->stock,
            'sku' => $producto->sku,
            'categoria_id' => $producto->categoria_id,
            'activo' => $producto->activo,
        ]);
    }

    public function delete(int $id): void
    {
        ProductoModel::findOrFail($id)->delete();
    }
}