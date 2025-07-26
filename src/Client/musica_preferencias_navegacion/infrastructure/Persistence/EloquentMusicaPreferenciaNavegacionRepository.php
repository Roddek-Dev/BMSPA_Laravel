<?php

namespace Src\Client\musica_preferencias_navegacion\infrastructure\Persistence;

use Src\Client\musica_preferencias_navegacion\domain\Repositories\MusicaPreferenciaNavegacionRepository;
use Src\Client\musica_preferencias_navegacion\domain\Entities\MusicaPreferenciaNavegacion;
use Src\Client\musica_preferencias_navegacion\infrastructure\Models\MusicaPreferenciaNavegacionModel;

class EloquentMusicaPreferenciaNavegacionRepository implements MusicaPreferenciaNavegacionRepository
{
    public function findById(int $id): ?MusicaPreferenciaNavegacion
    {
        $model = MusicaPreferenciaNavegacionModel::find($id);
        if (!$model) {
            return null;
        }
        return $this->toEntity($model);
    }

    public function findAll(): array
    {
        return MusicaPreferenciaNavegacionModel::all()->map(fn($model) => $this->toEntity($model))->toArray();
    }

    public function save(MusicaPreferenciaNavegacion $preferencia): void
    {
        MusicaPreferenciaNavegacionModel::create($this->toArray($preferencia));
    }

    public function update(int $id, MusicaPreferenciaNavegacion $preferencia): void
    {
        $model = MusicaPreferenciaNavegacionModel::findOrFail($id);
        $model->update($this->toArray($preferencia));
    }

    public function delete(int $id): void
    {
        MusicaPreferenciaNavegacionModel::findOrFail($id)->delete();
    }

    private function toEntity(MusicaPreferenciaNavegacionModel $model): MusicaPreferenciaNavegacion
    {
        return new MusicaPreferenciaNavegacion(
            $model->id,
            $model->nombre_opcion,
            $model->descripcion,
            $model->stream_url_ejemplo,
            $model->activo
        );
    }
    
    private function toArray(MusicaPreferenciaNavegacion $preferencia): array
    {
        return [
            'nombre_opcion' => $preferencia->nombre_opcion,
            'descripcion' => $preferencia->descripcion,
            'stream_url_ejemplo' => $preferencia->stream_url_ejemplo,
            'activo' => $preferencia->activo,
        ];
    }
}