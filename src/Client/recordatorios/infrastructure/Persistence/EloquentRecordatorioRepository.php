<?php

namespace Src\Client\recordatorios\infrastructure\Persistence;

use Src\Client\recordatorios\domain\Repositories\RecordatorioRepository;
use Src\Client\recordatorios\domain\Entities\Recordatorio;
use Src\Client\recordatorios\infrastructure\Models\RecordatorioModel;

class EloquentRecordatorioRepository implements RecordatorioRepository
{
    public function findById(int $id): ?Recordatorio
    {
        $model = RecordatorioModel::find($id);
        if (!$model) {
            return null;
        }
        return $this->toEntity($model);
    }

    public function findAll(): array
    {
        return RecordatorioModel::all()->map(fn($model) => $this->toEntity($model))->toArray();
    }

    public function save(Recordatorio $recordatorio): void
    {
        RecordatorioModel::create($this->toArray($recordatorio));
    }

    public function update(int $id, Recordatorio $recordatorio): void
    {
        $model = RecordatorioModel::findOrFail($id);
        $model->update($this->toArray($recordatorio));
    }

    public function delete(int $id): void
    {
        RecordatorioModel::findOrFail($id)->delete();
    }

    private function toEntity(RecordatorioModel $model): Recordatorio
    {
        // CORRECCIÓN: Formatear las fechas de Carbon a string para la entidad.
        return new Recordatorio(
            $model->id,
            $model->usuario_id,
            $model->agendamiento_id,
            $model->titulo,
            $model->descripcion,
            $model->fecha_hora_recordatorio->format('Y-m-d H:i:s'),
            $model->canal_notificacion,
            $model->enviado,
            $model->fecha_envio ? $model->fecha_envio->format('Y-m-d H:i:s') : null,
            $model->activo,
            $model->fijado
        );
    }

    private function toArray(Recordatorio $recordatorio): array
    {
        return [
            'usuario_id' => $recordatorio->usuario_id,
            'agendamiento_id' => $recordatorio->agendamiento_id,
            'titulo' => $recordatorio->titulo,
            'descripcion' => $recordatorio->descripcion,
            'fecha_hora_recordatorio' => $recordatorio->fecha_hora_recordatorio,
            'canal_notificacion' => $recordatorio->canal_notificacion,
            'enviado' => $recordatorio->enviado,
            'fecha_envio' => $recordatorio->fecha_envio,
            'activo' => $recordatorio->activo,
            'fijado' => $recordatorio->fijado,
        ];
    }
}