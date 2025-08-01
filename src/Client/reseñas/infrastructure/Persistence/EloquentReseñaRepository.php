<?php

namespace Src\Client\reseñas\infrastructure\Persistence;

use Src\Client\reseñas\domain\Entities\Reseña;
use Src\Client\reseñas\domain\Repositories\ReseñaRepository;
use Src\Client\reseñas\infrastructure\Models\ReseñaModel;

class EloquentReseñaRepository implements ReseñaRepository
{
    public function findById(int $id): ?Reseña
    {
        $model = ReseñaModel::find($id);
        return $model ? $this->toEntity($model) : null;
    }

    public function findAllByClient(int $clientId): array
    {
        return ReseñaModel::where('cliente_usuario_id', $clientId)
            ->get()
            ->map(fn($model) => $this->toEntity($model))
            ->toArray();
    }

          // NUEVA IMPLEMENTACIÓN
      public function findAllApprovedByItem(string $itemType, int $itemId): array
      {
          return ReseñaModel::where('reseñable_type', $itemType)
              ->where('reseñable_id', $itemId)
              ->where('aprobada', true) // Solo las aprobadas
              ->get()
              ->map(fn($model) => $this->toEntity($model))
              ->toArray();
      }
     
     // NUEVA IMPLEMENTACIÓN PARA ADMIN
     public function findAllPendingApproval(): array
     {
         return ReseñaModel::where('aprobada', false) // Solo las pendientes de aprobación
             ->with(['reseñable']) // Cargar la relación para obtener detalles del item reseñado
             ->orderBy('fecha_reseña', 'desc') // Ordenar por fecha más reciente
             ->get()
             ->map(fn($model) => $this->toEntity($model))
             ->toArray();
     }

    public function save(Reseña $reseña): void
    {
        ReseñaModel::create($this->toArray($reseña));
    }

    public function update(int $id, Reseña $reseña): void
    {
        $model = ReseñaModel::findOrFail($id);
        $model->update($this->toArray($reseña));
    }

    public function delete(int $id): void
    {
        ReseñaModel::findOrFail($id)->delete();
    }

    private function toEntity(ReseñaModel $model): Reseña
    {
        return new Reseña(
            $model->id,
            $model->cliente_usuario_id,
            $model->reseñable_type,
            $model->reseñable_id,
            $model->calificacion,
            $model->comentario,
            $model->aprobada, // Corregido
            $model->fecha_reseña->format('Y-m-d H:i:s') // Corregido
        );
    }

    private function toArray(Reseña $reseña): array
    {
        return [
            'cliente_usuario_id' => $reseña->cliente_usuario_id,
            'reseñable_type' => $reseña->reseñable_type,
            'reseñable_id' => $reseña->reseñable_id,
            'calificacion' => $reseña->calificacion,
            'comentario' => $reseña->comentario,
            'aprobada' => $reseña->aprobada, // Corregido
            'fecha_reseña' => $reseña->fecha_reseña, // Corregido
        ];
    }
}