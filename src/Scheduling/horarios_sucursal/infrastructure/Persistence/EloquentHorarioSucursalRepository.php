<?php

namespace Src\Scheduling\horarios_sucursal\infrastructure\Persistence;

use Src\Scheduling\horarios_sucursal\domain\Repositories\HorarioSucursalRepository;
use Src\Scheduling\horarios_sucursal\domain\Entities\HorarioSucursal;
use Src\Scheduling\horarios_sucursal\infrastructure\Models\HorarioSucursalModel;

class EloquentHorarioSucursalRepository implements HorarioSucursalRepository
{
    public function findById(int $id): ?HorarioSucursal
    {
        $model = HorarioSucursalModel::find($id);
        if (!$model) {
            return null;
        }
        return new HorarioSucursal(
            $model->id,
            $model->sucursal_id,
            $model->dia_semana,
            $model->hora_apertura,
            $model->hora_cierre,
            $model->esta_cerrado_regularmente
        );
    }

    public function findAll(): array
    {
        return HorarioSucursalModel::all()->map(function ($model) {
            return new HorarioSucursal(
                $model->id,
                $model->sucursal_id,
                $model->dia_semana,
                $model->hora_apertura,
                $model->hora_cierre,
                $model->esta_cerrado_regularmente
            );
        })->toArray();
    }

    public function save(HorarioSucursal $horario): void
    {
        HorarioSucursalModel::create([
            'sucursal_id' => $horario->sucursal_id,
            'dia_semana' => $horario->dia_semana,
            'hora_apertura' => $horario->hora_apertura,
            'hora_cierre' => $horario->hora_cierre,
            'esta_cerrado_regularmente' => $horario->esta_cerrado_regularmente,
        ]);
    }

    public function update(int $id, HorarioSucursal $horario): void
    {
        $model = HorarioSucursalModel::findOrFail($id);
        $model->update([
            'sucursal_id' => $horario->sucursal_id,
            'dia_semana' => $horario->dia_semana,
            'hora_apertura' => $horario->hora_apertura,
            'hora_cierre' => $horario->hora_cierre,
            'esta_cerrado_regularmente' => $horario->esta_cerrado_regularmente,
        ]);
    }

    public function delete(int $id): void
    {
        HorarioSucursalModel::findOrFail($id)->delete();
    }
}