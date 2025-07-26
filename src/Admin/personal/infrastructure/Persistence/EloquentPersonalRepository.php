<?php

namespace Src\Admin\personal\infrastructure\Persistence;

use Src\Admin\personal\domain\Repositories\PersonalRepository;
use Src\Admin\personal\domain\Entities\Personal;
use Src\Admin\personal\infrastructure\Models\PersonalModel;

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