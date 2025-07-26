<?php

namespace Src\Client\musica_preferencias_navegacion\infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMusicaPreferenciaNavegacionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre_opcion' => 'required|string|max:100|unique:musica_preferencias_navegacion,nombre_opcion',
            'descripcion' => 'nullable|string',
            'stream_url_ejemplo' => 'nullable|string|max:512|url',
            'activo' => 'sometimes|boolean',
        ];
    }
}