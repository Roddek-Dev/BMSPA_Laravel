<?php

namespace Src\Admin\promociones\infrastructure\Persistence;

use Src\Admin\promociones\domain\Repositories\PromocionRepository;
use Src\Admin\promociones\domain\Entities\Promocion;
use Src\Admin\promociones\infrastructure\Models\PromocionModel;

class EloquentPromocionRepository implements PromocionRepository
{
    public function findById(int $id): ?Promocion
    {
        $model = PromocionModel::find($id);
        return $model ? $this->toEntity($model) : null;
    }

    public function findAll(): array
    {
        return PromocionModel::all()->map(fn($model) => $this->toEntity($model))->toArray();
    }

    public function save(Promocion $promocion): void
    {
        PromocionModel::create($this->toArray($promocion));
    }

    public function update(int $id, Promocion $promocion): void
    {
        $model = PromocionModel::findOrFail($id);
        $model->update($this->toArray($promocion));
    }

    public function delete(int $id): void
    {
        PromocionModel::findOrFail($id)->delete();
    }
    
    private function toEntity(PromocionModel $model): Promocion
    {
        return new Promocion(
            $model->id,
            $model->codigo,
            $model->nombre,
            $model->descripcion,
            $model->tipo_descuento,
            $model->valor_descuento,
            $model->fecha_inicio->format('Y-m-d H:i:s'),
            $model->fecha_fin ? $model->fecha_fin->format('Y-m-d H:i:s') : null,
            $model->usos_maximos_total,
            $model->usos_maximos_por_cliente,
            $model->usos_actuales,
            $model->activo,
            $model->aplica_a_todos_productos,
            $model->aplica_a_todos_servicios
        );
    }
    
    private function toArray(Promocion $promocion): array
    {
        return [
            'codigo' => $promocion->codigo,
            'nombre' => $promocion->nombre,
            'descripcion' => $promocion->descripcion,
            'tipo_descuento' => $promocion->tipo_descuento,
            'valor_descuento' => $promocion->valor_descuento,
            'fecha_inicio' => $promocion->fecha_inicio,
            'fecha_fin' => $promocion->fecha_fin,
            'usos_maximos_total' => $promocion->usos_maximos_total,
            'usos_maximos_por_cliente' => $promocion->usos_maximos_por_cliente,
            'usos_actuales' => $promocion->usos_actuales,
            'activo' => $promocion->activo,
            'aplica_a_todos_productos' => $promocion->aplica_a_todos_productos,
            'aplica_a_todos_servicios' => $promocion->aplica_a_todos_servicios,
        ];
    }
}