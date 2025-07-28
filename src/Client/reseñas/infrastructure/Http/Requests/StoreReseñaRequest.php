<?php

namespace Src\Client\reseñas\infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreReseñaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // AÑADIMOS 'producto' A LA LISTA DE TIPOS VÁLIDOS
            'reseñable_type' => ['required', 'string', Rule::in(['sucursal', 'servicio', 'producto'])],
            'reseñable_id' => 'required|integer',
            'calificacion' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string',
        ];
    }
}