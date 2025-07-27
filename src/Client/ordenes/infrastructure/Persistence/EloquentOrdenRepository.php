<?php

namespace Src\Client\ordenes\infrastructure\Persistence;

use Illuminate\Support\Facades\DB;
use Src\Client\ordenes\domain\Repositories\OrdenRepository;
use Src\Client\ordenes\domain\Entities\Orden;
use Src\Client\ordenes\infrastructure\Models\OrdenModel;

class EloquentOrdenRepository implements OrdenRepository
{
    public function findById(int $id): ?Orden
    {
        $model = OrdenModel::with('detalles')->find($id);
        return $model ? $this->toEntity($model) : null;
    }

    public function findAllByClient(int $clientId): array
    {
        return OrdenModel::where('cliente_usuario_id', $clientId)
            ->with('detalles')
            ->get()
            ->map(fn($model) => $this->toEntity($model))
            ->toArray();
    }

    public function save(Orden $orden, array $detalles): Orden
    {
        // Usamos una transacción para asegurar la integridad de los datos
        $ordenModel = DB::transaction(function () use ($orden, $detalles) {
            $createdOrden = OrdenModel::create($this->toArray($orden));
            $createdOrden->detalles()->createMany($detalles);
            return $createdOrden;
        });

        // Devolvemos la orden recién creada con sus detalles
        return $this->findById($ordenModel->id);
    }

    public function update(int $id, Orden $orden): void
    {
        $model = OrdenModel::findOrFail($id);
        $model->update($this->toArray($orden));
    }

    public function delete(int $id): void
    {
        OrdenModel::findOrFail($id)->delete();
    }
    
    private function toEntity(OrdenModel $model): Orden
    {
        return new Orden(
            $model->id,
            $model->cliente_usuario_id,
            $model->numero_orden,
            $model->fecha_orden->format('Y-m-d H:i:s'),
            $model->fecha_recibida ? $model->fecha_recibida->format('Y-m-d H:i:s') : null,
            $model->subtotal,
            $model->descuento_total,
            $model->impuestos_total,
            $model->total_orden,
            $model->estado_orden,
            $model->notas_orden
        );
    }
    
    private function toArray(Orden $orden): array
    {
        return [
            'cliente_usuario_id' => $orden->cliente_usuario_id,
            'numero_orden' => $orden->numero_orden,
            'fecha_orden' => $orden->fecha_orden,
            'fecha_recibida' => $orden->fecha_recibida,
            'subtotal' => $orden->subtotal,
            'descuento_total' => $orden->descuento_total,
            'impuestos_total' => $orden->impuestos_total,
            'total_orden' => $orden->total_orden,
            'estado_orden' => $orden->estado_orden,
            'notas_orden' => $orden->notas_orden,
        ];
    }
}