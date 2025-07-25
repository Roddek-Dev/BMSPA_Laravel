<?php

namespace Src\Client\direcciones\infrastructure\Persistence;

use Illuminate\Support\Facades\DB;
use Src\Client\direcciones\domain\Repositories\DireccionRepository;
use Src\Client\direcciones\domain\Entities\Direccion;
use Src\Client\direcciones\infrastructure\Models\DireccionModel;
use Src\Client\usuarios\infrastructure\Persistence\Eloquent\UsuarioModel;

class EloquentDireccionRepository implements DireccionRepository
{
    public function findById(int $id): ?Direccion
    {
        $model = DireccionModel::find($id);
        if (!$model) {
            return null;
        }
        return $this->toDomain($model);
    }

    public function findAllByClient(int $clientId): array
    {
        return DireccionModel::where('direccionable_id', $clientId)
            ->where('direccionable_type', UsuarioModel::class)
            ->get()
            ->map(fn ($model) => $this->toDomain($model))
            ->toArray();
    }

    public function save(Direccion $direccion): void
    {
        DB::transaction(function () use ($direccion) {
            if ($direccion->es_predeterminada) {
                $this->resetDefault($direccion->direccionable_id);
            }

            DireccionModel::create([
                'direccionable_id' => $direccion->direccionable_id,
                'direccionable_type' => $direccion->direccionable_type,
                'direccion' => $direccion->direccion,
                'colonia' => $direccion->colonia,
                'codigo_postal' => $direccion->codigo_postal,
                'ciudad' => $direccion->ciudad,
                'estado' => $direccion->estado,
                'referencias' => $direccion->referencias,
                'es_predeterminada' => $direccion->es_predeterminada,
            ]);
        });
    }

    public function update(int $id, Direccion $direccion): void
    {
        DB::transaction(function () use ($id, $direccion) {
            $model = DireccionModel::findOrFail($id);

            if ($direccion->es_predeterminada) {
                $this->resetDefault($model->direccionable_id);
            }

            $model->update([
                'direccion' => $direccion->direccion,
                'colonia' => $direccion->colonia,
                'codigo_postal' => $direccion->codigo_postal,
                'ciudad' => $direccion->ciudad,
                'estado' => $direccion->estado,
                'referencias' => $direccion->referencias,
                'es_predeterminada' => $direccion->es_predeterminada,
            ]);
        });
    }

    public function delete(int $id): void
    {
        DireccionModel::findOrFail($id)->delete();
    }

    public function setAsDefault(int $id, int $clientId): void
    {
        DB::transaction(function () use ($id, $clientId) {
            $this->resetDefault($clientId);
            DireccionModel::where('id', $id)
                ->where('direccionable_id', $clientId)
                ->where('direccionable_type', UsuarioModel::class)
                ->firstOrFail()
                ->update(['es_predeterminada' => true]);
        });
    }

    private function resetDefault(int $clientId): void
    {
        DireccionModel::where('direccionable_id', $clientId)
            ->where('direccionable_type', UsuarioModel::class)
            ->where('es_predeterminada', true)
            ->update(['es_predeterminada' => false]);
    }

    private function toDomain(DireccionModel $model): Direccion
    {
        return new Direccion(
            $model->id,
            $model->direccionable_id,
            $model->direccionable_type,
            $model->direccion,
            $model->colonia,
            $model->codigo_postal,
            $model->ciudad,
            $model->estado,
            $model->referencias,
            $model->es_predeterminada
        );
    }
}