<?php

namespace Src\Scheduling\agendamientos\infrastructure\Persistence;

use Src\Scheduling\agendamientos\domain\Repositories\AgendamientoRepository;
use Src\Scheduling\agendamientos\domain\Entities\Agendamiento;
use Src\Scheduling\agendamientos\infrastructure\Models\AgendamientoModel;

class EloquentAgendamientoRepository implements AgendamientoRepository
{
    public function findById(int $id): ?Agendamiento
    {
        $model = AgendamientoModel::find($id);
        if (!$model) {
            return null;
        }
        return new Agendamiento(
            $model->id,
            $model->cliente_usuario_id,
            $model->personal_id,
            $model->servicio_id,
            $model->sucursal_id,
            $model->fecha_hora_inicio,
            $model->fecha_hora_fin,
            $model->precio_final,
            $model->estado,
            $model->notas_cliente,
            $model->notas_internas
        );
    }

    public function findAll(): array
    {
        return AgendamientoModel::all()->map(function ($model) {
            return new Agendamiento(
                $model->id,
                $model->cliente_usuario_id,
                $model->personal_id,
                $model->servicio_id,
                $model->sucursal_id,
                $model->fecha_hora_inicio,
                $model->fecha_hora_fin,
                $model->precio_final,
                $model->estado,
                $model->notas_cliente,
                $model->notas_internas
            );
        })->toArray();
    }

    public function save(Agendamiento $agendamiento): void
    {
        AgendamientoModel::create([
            'cliente_usuario_id' => $agendamiento->cliente_usuario_id,
            'personal_id' => $agendamiento->personal_id,
            'servicio_id' => $agendamiento->servicio_id,
            'sucursal_id' => $agendamiento->sucursal_id,
            'fecha_hora_inicio' => $agendamiento->fecha_hora_inicio,
            'fecha_hora_fin' => $agendamiento->fecha_hora_fin,
            'precio_final' => $agendamiento->precio_final,
            'estado' => $agendamiento->estado,
            'notas_cliente' => $agendamiento->notas_cliente,
            'notas_internas' => $agendamiento->notas_internas,
        ]);
    }

    public function update(int $id, Agendamiento $agendamiento): void
    {
        $model = AgendamientoModel::findOrFail($id);
        $model->update([
            'cliente_usuario_id' => $agendamiento->cliente_usuario_id,
            'personal_id' => $agendamiento->personal_id,
            'servicio_id' => $agendamiento->servicio_id,
            'sucursal_id' => $agendamiento->sucursal_id,
            'fecha_hora_inicio' => $agendamiento->fecha_hora_inicio,
            'fecha_hora_fin' => $agendamiento->fecha_hora_fin,
            'precio_final' => $agendamiento->precio_final,
            'estado' => $agendamiento->estado,
            'notas_cliente' => $agendamiento->notas_cliente,
            'notas_internas' => $agendamiento->notas_internas,
        ]);
    }

    public function delete(int $id): void
    {
        AgendamientoModel::findOrFail($id)->delete();
    }
}