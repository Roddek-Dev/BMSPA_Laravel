<?php

namespace Src\Client\musica_preferencias_navegacion\infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMusicaPreferenciaNavegacionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $preferenciaId = $this->route('musica_preferencia');

        return [
            'nombre_opcion' => ['sometimes', 'required', 'string', 'max:100', Rule::unique('musica_preferencias_navegacion')->ignore($preferenciaId)],
            'descripcion' => 'nullable|string',
            'stream_url_ejemplo' => 'nullable|string|max:512|url',
            'activo' => 'sometimes|boolean',
        ];
    }
}